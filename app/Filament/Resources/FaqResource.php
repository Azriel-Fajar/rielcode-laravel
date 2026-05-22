<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $recordTitleAttribute = 'question';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('show_on_studio')
                    ->label('Show on Studio page')
                    ->default(true),
                Forms\Components\Toggle::make('show_on_services')
                    ->label('Show on Services page')
                    ->default(false),
                Forms\Components\Toggle::make('is_visible')
                    ->label('Visible')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable()->label('Order')->width(60),
                Tables\Columns\TextColumn::make('question')->searchable()->limit(60),
                Tables\Columns\IconColumn::make('show_on_studio')->boolean()->label('Studio'),
                Tables\Columns\IconColumn::make('show_on_services')->boolean()->label('Services'),
                Tables\Columns\IconColumn::make('is_visible')->boolean()->label('Visible'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('show_on_studio'),
                Tables\Filters\TernaryFilter::make('show_on_services'),
                Tables\Filters\TernaryFilter::make('is_visible'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
