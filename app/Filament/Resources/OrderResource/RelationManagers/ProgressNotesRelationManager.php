<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProgressNotesRelationManager extends RelationManager
{
    protected static string $relationship = 'progressNotes';

    protected static ?string $title = 'Progress Updates';

    protected static ?string $recordTitleAttribute = 'note';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('note')
                ->required()
                ->rows(4)
                ->columnSpanFull()
                ->helperText('Shown to the client under "Latest Updates" on the progress page. Newest appears first.'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('note')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('M j, Y · H:i')->label('Posted')->sortable(),
                Tables\Columns\TextColumn::make('note')->limit(80)->wrap()->label('Update'),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_at'] = now();

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
