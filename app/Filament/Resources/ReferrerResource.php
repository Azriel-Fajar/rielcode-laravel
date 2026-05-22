<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferrerResource\Pages;
use App\Models\Referrer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferrerResource extends Resource
{
    protected static ?string $model = Referrer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(100),
                Forms\Components\TextInput::make('phone')->tel()->maxLength(20),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(20)
                    ->afterStateUpdated(fn ($set, $state) => $set('code', strtoupper($state))),
                Forms\Components\TextInput::make('commission_rate')->numeric()->required()->suffix('%'),
                Forms\Components\Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\TextColumn::make('commission_rate')->suffix('%')->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(['success' => 'active', 'danger' => 'inactive']),
                Tables\Columns\TextColumn::make('commissions_sum_commission_amount')
                    ->label('Total Earned')
                    ->sum('commissions', 'commission_amount')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state ?? 0, 0, ',', '.')),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (Referrer $record) => $record->status === 'active' ? 'Deactivate' : 'Activate')
                    ->action(fn (Referrer $record) => $record->update([
                        'status' => $record->status === 'active' ? 'inactive' : 'active',
                    ])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->disabled(fn (Referrer $record) => $record->commissions()->count() > 0),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReferrers::route('/'),
            'create' => Pages\CreateReferrer::route('/create'),
            'edit' => Pages\EditReferrer::route('/{record}/edit'),
        ];
    }
}
