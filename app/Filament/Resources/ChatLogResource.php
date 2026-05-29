<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatLogResource\Pages;
use App\Models\ChatLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChatLogResource extends Resource
{
    protected static ?string $model = ChatLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left';

    protected static ?string $navigationGroup = 'Logs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('user_message')->readOnly()->columnSpanFull(),
                Forms\Components\Textarea::make('bot_reply')->readOnly()->columnSpanFull(),
                Forms\Components\TextInput::make('tag')->readOnly(),
                Forms\Components\TextInput::make('ip_address')->readOnly(),
                Forms\Components\TextInput::make('input_tokens')->readOnly(),
                Forms\Components\TextInput::make('output_tokens')->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('user_message')->limit(60)->searchable(),
                Tables\Columns\TextColumn::make('tag')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ip_address'),
                Tables\Columns\TextColumn::make('input_tokens')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('output_tokens')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tag'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
                            ->when($data['until'], fn ($q, $v) => $q->whereDate('created_at', '<=', $v));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatLogs::route('/'),
        ];
    }
}
