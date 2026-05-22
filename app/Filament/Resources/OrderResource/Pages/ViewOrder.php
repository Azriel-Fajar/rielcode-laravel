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
                    $order   = $this->record;
                    $svc     = app(InvoiceNumberService::class);
                    $invNum  = $svc->generate('deposit');
                    $amount  = round($order->final_price * 0.20, 2);
                    $due     = now()->addDays(3)->toDateString();
                    $currency = $order->invoice_currency ?? 'IDR';

                    OrderPayment::create([
                        'order_id'       => $order->id,
                        'stage'          => 'deposit',
                        'invoice_number' => $invNum,
                        'amount'         => $amount,
                        'currency'       => $currency,
                        'status'         => 'draft',
                        'due_date'       => $due,
                    ]);

                    Notification::make()
                        ->title('Deposit invoice created: ' . $invNum)
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
                    $order   = $this->record;
                    $svc     = app(InvoiceNumberService::class);
                    $invNum  = $svc->generate('final');
                    $amount  = round($order->final_price * 0.80, 2);
                    $due     = now()->addDays(7)->toDateString();
                    $currency = $order->invoice_currency ?? 'IDR';

                    OrderPayment::create([
                        'order_id'       => $order->id,
                        'stage'          => 'final',
                        'invoice_number' => $invNum,
                        'amount'         => $amount,
                        'currency'       => $currency,
                        'status'         => 'draft',
                        'due_date'       => $due,
                    ]);

                    Notification::make()
                        ->title('Final invoice created: ' . $invNum)
                        ->success()
                        ->send();
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
