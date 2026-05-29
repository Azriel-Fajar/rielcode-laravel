<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')->required(),
                Forms\Components\TextInput::make('business_name'),
                Forms\Components\TextInput::make('role_title'),
                Forms\Components\TextInput::make('headline'),
                Forms\Components\Select::make('rating')
                    ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                    ->required(),
                Forms\Components\TextInput::make('project_url'),
                Forms\Components\Textarea::make('problem_before')->columnSpanFull(),
                Forms\Components\Textarea::make('solution_after')->columnSpanFull(),
                Forms\Components\Textarea::make('recommendation')->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->required(),
                Forms\Components\TextInput::make('client_email')->email()->readOnly(),
                Forms\Components\Toggle::make('consent_given')->disabled(),
                Forms\Components\TextInput::make('ip_address')->readOnly(),
                Forms\Components\DateTimePicker::make('submitted_at')->readOnly(),
                Forms\Components\DateTimePicker::make('reviewed_at')->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('business_name')->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state).str_repeat('☆', 5 - (int) $state)),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('submitted_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (Testimonial $record) => $record->update(['status' => 'approved', 'reviewed_at' => now()]))
                    ->visible(fn (Testimonial $record) => $record->status === 'pending'),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(fn (Testimonial $record) => $record->update(['status' => 'rejected', 'reviewed_at' => now()]))
                    ->visible(fn (Testimonial $record) => $record->status === 'pending'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
