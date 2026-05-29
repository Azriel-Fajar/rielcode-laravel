<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OrderPayment;
use App\Services\InvoiceNumberService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('generate_deposit')
                ->label('Generate Deposit Invoice')
                ->icon('heroicon-o-document-plus')
                ->color('warning')
                ->visible(fn () => ! $this->record->payments()->where('stage', 'deposit')->exists())
                ->action(function () {
                    $order = $this->record;
                    $svc = app(InvoiceNumberService::class);
                    $invNum = $svc->generate('deposit');
                    $amount = round($order->final_price * 0.20, 2);
                    $due = now()->addDays(3)->toDateString();
                    $currency = $order->invoice_currency ?? 'IDR';

                    OrderPayment::create([
                        'order_id' => $order->id,
                        'stage' => 'deposit',
                        'invoice_number' => $invNum,
                        'amount' => $amount,
                        'currency' => $currency,
                        'status' => 'draft',
                        'due_date' => $due,
                    ]);

                    Notification::make()
                        ->title('Deposit invoice created: '.$invNum)
                        ->success()
                        ->send();
                }),

            Actions\Action::make('generate_final')
                ->label('Generate Final Invoice')
                ->icon('heroicon-o-document-check')
                ->color('success')
                ->visible(function () {
                    $deposit = $this->record->payments()->where('stage', 'deposit')->first();
                    $finalExists = $this->record->payments()->where('stage', 'final')->exists();

                    return $deposit && $deposit->status === 'paid' && ! $finalExists;
                })
                ->action(function () {
                    $order = $this->record;
                    $svc = app(InvoiceNumberService::class);
                    $invNum = $svc->generate('final');
                    $amount = round($order->final_price * 0.80, 2);
                    $due = now()->addDays(7)->toDateString();
                    $currency = $order->invoice_currency ?? 'IDR';

                    OrderPayment::create([
                        'order_id' => $order->id,
                        'stage' => 'final',
                        'invoice_number' => $invNum,
                        'amount' => $amount,
                        'currency' => $currency,
                        'status' => 'draft',
                        'due_date' => $due,
                    ]);

                    Notification::make()
                        ->title('Final invoice created: '.$invNum)
                        ->success()
                        ->send();
                }),

            Actions\Action::make('mark_deposit_sent')
                ->label('Mark Deposit Sent')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->visible(fn () => ($p = $this->record->depositPayment) && in_array($p->status, ['draft', 'overdue']))
                ->requiresConfirmation()
                ->modalDescription('This will mark the deposit invoice as sent to the client.')
                ->action(function () {
                    $this->record->depositPayment->update(['status' => 'sent', 'sent_at' => now()]);
                    Notification::make()->title('Deposit marked as sent')->success()->send();
                    $this->redirect(static::getResource()::getUrl('view', ['record' => $this->record]));
                }),

            Actions\Action::make('mark_deposit_paid')
                ->label('Mark Deposit Paid')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => ($p = $this->record->depositPayment) && in_array($p->status, ['sent', 'overdue']))
                ->requiresConfirmation()
                ->modalDescription('This will mark the deposit as paid and move the order to On Progress.')
                ->action(function () {
                    $deposit = $this->record->depositPayment;
                    $deposit->update(['status' => 'paid', 'paid_at' => now()]);
                    if ($this->record->status === 'Pending') {
                        $this->record->update(['status' => 'On Progress']);
                    }
                    Notification::make()->title('Deposit marked as paid - order is now On Progress')->success()->send();
                    $this->redirect(static::getResource()::getUrl('view', ['record' => $this->record]));
                }),

            Actions\Action::make('mark_final_sent')
                ->label('Mark Final Sent')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->visible(fn () => ($p = $this->record->finalPayment) && in_array($p->status, ['draft', 'overdue']))
                ->requiresConfirmation()
                ->modalDescription('This will mark the final invoice as sent to the client.')
                ->action(function () {
                    $this->record->finalPayment->update(['status' => 'sent', 'sent_at' => now()]);
                    Notification::make()->title('Final invoice marked as sent')->success()->send();
                    $this->redirect(static::getResource()::getUrl('view', ['record' => $this->record]));
                }),

            Actions\Action::make('mark_final_paid')
                ->label('Mark Final Paid')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => ($p = $this->record->finalPayment) && in_array($p->status, ['sent', 'overdue']))
                ->requiresConfirmation()
                ->modalDescription('This will mark the final payment as paid and complete the order.')
                ->action(function () {
                    $this->record->finalPayment->update(['status' => 'paid', 'paid_at' => now()]);
                    $this->record->update(['status' => 'Done', 'invoice_status' => 'Paid']);
                    Notification::make()->title('Final payment received - order marked as Done')->success()->send();
                    $this->redirect(static::getResource()::getUrl('view', ['record' => $this->record]));
                }),
        ];
    }

    public function getContentTabLabel(): ?string
    {
        return 'Details';
    }

    public function getFooter(): ?View
    {
        return null;
    }

    public function getPayments()
    {
        return $this->record->payments()->orderBy('stage')->get();
    }
}
