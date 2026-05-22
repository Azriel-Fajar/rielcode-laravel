<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialInviteResource\Pages;
use App\Models\TestimonialInvite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TestimonialInviteResource extends Resource
{
    protected static ?string $model = TestimonialInvite::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')->required()->maxLength(100),
                Forms\Components\TextInput::make('token')->readOnly()->maxLength(64),
                Forms\Components\DateTimePicker::make('used_at')->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('token')->limit(20),
                Tables\Columns\IconColumn::make('used_at')
                    ->label('Used')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->used_at !== null),
                Tables\Columns\TextColumn::make('used_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('copy_link')
                    ->label('Copy Invite Link')
                    ->icon('heroicon-o-clipboard')
                    ->action(function (TestimonialInvite $record) {
                        $url = 'https://testimonials.rielcode.com/?t=' . $record->token;
                        Notification::make()
                            ->title('Invite link')
                            ->body($url)
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->disabled(fn (TestimonialInvite $record) => $record->used_at !== null),
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
            'index' => Pages\ListTestimonialInvites::route('/'),
            'create' => Pages\CreateTestimonialInvite::route('/create'),
            'edit' => Pages\EditTestimonialInvite::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['token'] = Str::random(64);
        return $data;
    }
}
