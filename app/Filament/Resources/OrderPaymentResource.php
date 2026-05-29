<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderPaymentResource\Pages;
use App\Models\OrderPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderPaymentResource extends Resource
{
    protected static ?string $model = OrderPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Finance';

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Payment';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('order_id')
                ->label('Order')
                ->relationship(
                    'order',
                    'order_name',
                    fn ($query) => $query->whereIn('invoice_status', ['Unpaid', 'Partial'])->orderBy('created_at', 'desc')
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->order_name} - {$record->invoice_status} ({$record->invoice_currency} ".
                    number_format($record->final_price, 0, ',', '.').')'
                )
                ->helperText('Only shows orders with Unpaid or Partial invoice status.')
                ->required()
                ->searchable(),
            Forms\Components\Select::make('stage')
                ->options(['deposit' => 'Deposit (20%)', 'final' => 'Final (80%)'])
                ->required(),
            Forms\Components\TextInput::make('invoice_number')->required()->maxLength(30),
            Forms\Components\TextInput::make('amount')->numeric()->required()->prefix('Amount'),
            Forms\Components\Select::make('currency')
                ->options(['IDR' => 'IDR', 'USD' => 'USD'])
                ->default('IDR')
                ->required(),
            Forms\Components\Select::make('status')
                ->options(['draft' => 'Draft', 'sent' => 'Sent', 'paid' => 'Paid', 'overdue' => 'Overdue'])
                ->default('draft')
                ->required(),
            Forms\Components\DatePicker::make('due_date'),
            Forms\Components\Textarea::make('notes')->rows(2)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->fontFamily('mono')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('order.order_name')
                    ->label('Client')
                    ->searchable()
                    ->limit(28),
                Tables\Columns\BadgeColumn::make('stage')
                    ->colors(['primary' => 'deposit', 'success' => 'final']),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                    ]),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state, $record) => $record->amountFormatted()),
                Tables\Columns\TextColumn::make('due_date')->date('d M Y')->label('Due'),
                Tables\Columns\TextColumn::make('paid_at')->dateTime('d M Y')->label('Paid')->placeholder('-'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stage')
                    ->options(['deposit' => 'Deposit', 'final' => 'Final']),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'sent' => 'Sent', 'paid' => 'Paid', 'overdue' => 'Overdue']),
                Tables\Filters\SelectFilter::make('currency')
                    ->options(['IDR' => 'IDR', 'USD' => 'USD']),
            ])
            ->actions([
                Tables\Actions\Action::make('view_invoice')
                    ->label('View Invoice')
                    ->icon('heroicon-o-eye')
                    ->url(fn (OrderPayment $record) => route('invoice.show', $record->invoice_number))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('mark_sent')
                    ->label('Mark Sent')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('warning')
                    ->visible(fn (OrderPayment $r) => in_array($r->status, ['draft', 'overdue']))
                    ->action(function (OrderPayment $record) {
                        $record->update(['status' => 'sent', 'sent_at' => now()]);
                        Notification::make()->title('Marked as sent')->success()->send();
                    })
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('mark_paid')
                    ->label('Mark Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (OrderPayment $r) => in_array($r->status, ['sent', 'overdue']))
                    ->action(function (OrderPayment $record) {
                        $record->update(['status' => 'paid', 'paid_at' => now()]);

                        // Stage cascade
                        $order = $record->order;
                        if ($record->stage === 'deposit' && $order->status === 'Pending') {
                            $order->update(['status' => 'On Progress']);
                        } elseif ($record->stage === 'final') {
                            $order->update(['status' => 'Completed']);
                        }

                        Notification::make()->title('Marked as paid')->success()->send();
                    })
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('whatsapp')
                    ->label('Send WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->color('gray')
                    ->url(function (OrderPayment $record) {
                        $phone = config('payment.wa_phone');
                        $url = route('invoice.show', $record->invoice_number);
                        $amount = $record->amountFormatted();
                        $name = $record->order?->order_name ?? 'there';
                        $msg = urlencode("Hi {$name}, here is your invoice for {$record->stageLabel()} ({$amount}):\n{$url}");

                        return "https://wa.me/{$phone}?text={$msg}";
                    })
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderPayments::route('/'),
            'create' => Pages\CreateOrderPayment::route('/create'),
            'edit' => Pages\EditOrderPayment::route('/{record}/edit'),
        ];
    }
}
