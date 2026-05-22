<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identity')
                    ->schema([
                        Forms\Components\TextInput::make('package_name')->required()->maxLength(100),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->helperText('URL slug: landing, starter, pro, business, custom'),
                        Forms\Components\Textarea::make('blurb')->rows(2)->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('idr_price')->numeric()->required()->prefix('Rp')->label('IDR Price'),
                        Forms\Components\TextInput::make('original_idr')->numeric()->prefix('Rp')->label('Original IDR (strike price)'),
                        Forms\Components\TextInput::make('us_price')->numeric()->required()->prefix('$')->label('USD Price')->step('0.01'),
                        Forms\Components\TextInput::make('original_usd')->numeric()->prefix('$')->label('Original USD (strike price)')->step('0.01'),
                    ])->columns(2),

                Forms\Components\Section::make('Delivery')
                    ->schema([
                        Forms\Components\TextInput::make('delivery_days_min')->numeric()->label('Min days'),
                        Forms\Components\TextInput::make('delivery_days_max')->numeric()->label('Max days'),
                    ])->columns(2),

                Forms\Components\Section::make('Perks & Display')
                    ->schema([
                        Forms\Components\Toggle::make('includes_free_hosting')->label('Free hosting included')->inline(false),
                        Forms\Components\Toggle::make('includes_free_domain')->label('Free domain included')->inline(false),
                        Forms\Components\Toggle::make('is_popular')->label('Mark as Popular')->inline(false),
                        Forms\Components\Select::make('badge_color')
                            ->options(['green' => 'Green', 'blue' => 'Blue', 'amber' => 'Amber'])
                            ->label('Badge color'),
                        Forms\Components\Toggle::make('is_visible')->default(true)->inline(false),
                        Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    ])->columns(3),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\Textarea::make('features_json')
                            ->label('Features (JSON array)')
                            ->helperText('["Feature 1","Feature 2"]')
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->width(40)->sortable(),
                Tables\Columns\TextColumn::make('package_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->badge(),
                Tables\Columns\TextColumn::make('idr_price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->label('IDR'),
                Tables\Columns\TextColumn::make('us_price')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 0))
                    ->label('USD'),
                Tables\Columns\IconColumn::make('includes_free_hosting')->boolean()->label('Hosting'),
                Tables\Columns\IconColumn::make('is_popular')->boolean()->label('Popular'),
                Tables\Columns\IconColumn::make('is_visible')->boolean()->label('Visible'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->disabled(fn (Package $record) => $record->ordersRel()->count() > 0),
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
