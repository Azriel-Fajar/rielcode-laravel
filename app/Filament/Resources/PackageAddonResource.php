<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageAddonResource\Pages;
use App\Models\PackageAddon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageAddonResource extends Resource
{
    protected static ?string $model = PackageAddon::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Add-ons';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(100),
                Forms\Components\Select::make('type')
                    ->options([
                        'one_time' => 'One-time fee',
                        'per_page' => 'Per page',
                        'monthly'  => 'Monthly',
                    ])
                    ->default('one_time')
                    ->required(),
                Forms\Components\Textarea::make('description')->rows(2)->columnSpanFull(),
                Forms\Components\TextInput::make('price_idr')->numeric()->required()->prefix('Rp'),
                Forms\Components\TextInput::make('price_usd')->numeric()->required()->prefix('$')->step('0.01'),
                Forms\Components\Toggle::make('is_visible')->default(true),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('Order')->width(60),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\BadgeColumn::make('type')->colors([
                    'primary' => 'one_time',
                    'success' => 'per_page',
                    'warning' => 'monthly',
                ]),
                Tables\Columns\TextColumn::make('price_idr')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('price_usd')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 2)),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options([
                    'one_time' => 'One-time',
                    'per_page' => 'Per page',
                    'monthly'  => 'Monthly',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPackageAddons::route('/'),
            'create' => Pages\CreatePackageAddon::route('/create'),
            'edit'   => Pages\EditPackageAddon::route('/{record}/edit'),
        ];
    }
}
