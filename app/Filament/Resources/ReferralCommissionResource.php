<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralCommissionResource\Pages;
use App\Models\ReferralCommission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferralCommissionResource extends Resource
{
    protected static ?string $model = ReferralCommission::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('referrer_id')
                    ->relationship('referrer', 'name')
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'order_name')
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('order_amount')->numeric()->readOnly(),
                Forms\Components\TextInput::make('commission_amount')->numeric()->readOnly(),
                Forms\Components\Select::make('status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'cancelled' => 'Cancelled'])
                    ->required(),
                Forms\Components\DateTimePicker::make('paid_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('referrer.name')->label('Referrer')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('order.order_name')->label('Order')->searchable(),
                Tables\Columns\TextColumn::make('order_amount')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state ?? 0, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_amount')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state ?? 0, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(['warning' => 'pending', 'success' => 'paid', 'danger' => 'cancelled']),
                Tables\Columns\TextColumn::make('paid_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('referrer')->relationship('referrer', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'cancelled' => 'Cancelled']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_paid')
                        ->label('Mark as Paid')
                        ->action(fn ($records) => $records->each->update(['status' => 'paid', 'paid_at' => now()])),
                    Tables\Actions\BulkAction::make('cancel')
                        ->label('Cancel')
                        ->action(fn ($records) => $records->each->update(['status' => 'cancelled'])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReferralCommissions::route('/'),
            'create' => Pages\CreateReferralCommission::route('/create'),
            'edit' => Pages\EditReferralCommission::route('/{record}/edit'),
        ];
    }
}
