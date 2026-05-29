<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->disabledOn('edit')
                    ->helperText('Internal identifier used in templates as SiteSetting::get(\'this_key\'). Cannot be changed after saving.'),
                Forms\Components\Select::make('value_type')
                    ->options([
                        'string' => 'String',
                        'image' => 'Image',
                        'html' => 'HTML',
                        'json' => 'JSON',
                    ])->required()->reactive(),
                Forms\Components\TextInput::make('group')->required(),
                Forms\Components\TextInput::make('label')->required(),
                Forms\Components\TextInput::make('hint')
                    ->columnSpanFull()
                    ->helperText('Describe what this setting does and where it appears on the site. This note is shown when editing the value.'),

                Forms\Components\TextInput::make('value')
                    ->columnSpanFull()
                    ->helperText(fn ($get) => $get('hint') ?: null)
                    ->visible(fn ($get) => $get('value_type') === 'string'),

                Forms\Components\Textarea::make('value')
                    ->rows(6)
                    ->columnSpanFull()
                    ->helperText(fn ($get) => $get('hint') ?: null)
                    ->visible(fn ($get) => in_array($get('value_type'), ['html', 'json'])),

                Forms\Components\FileUpload::make('value')
                    ->image()
                    ->imagePreviewHeight('120')
                    ->disk('public')
                    ->directory('site-settings')
                    ->maxSize(4096)
                    ->columnSpanFull()
                    ->helperText(fn ($get) => $get('hint') ?: null)
                    ->visible(fn ($get) => $get('value_type') === 'image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')->sortable(),
                Tables\Columns\TextColumn::make('key')->searchable(),
                Tables\Columns\TextColumn::make('label')->limit(40),
                Tables\Columns\BadgeColumn::make('value_type'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->since(),
            ])
            ->groups([
                Tables\Grouping\Group::make('group')->label('Group'),
            ])
            ->defaultGroup('group')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('group');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
