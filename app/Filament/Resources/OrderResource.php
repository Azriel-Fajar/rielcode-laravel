<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\OrderAccessToken;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Client Info')
                    ->schema([
                        Forms\Components\TextInput::make('order_name')->required()->maxLength(30),
                        Forms\Components\TextInput::make('email')->email()->required()->maxLength(50),
                        Forms\Components\TextInput::make('phone_number')->tel()->required()->maxLength(13),
                    ])->columns(3),

                Forms\Components\Section::make('Package')
                    ->schema([
                        Forms\Components\TextInput::make('package')
                            ->label('Plan name (display)')
                            ->required()
                            ->helperText('The plan label shown to the client (e.g. "Pro Plan"). Free text. For Custom Plan orders, type exactly "Custom Plan" so the custom specs render.'),
                        Forms\Components\Select::make('package_id')
                            ->label('Linked package')
                            ->relationship('package', 'package_name')
                            ->required()
                            ->helperText('The actual package record this order is tied to (drives pricing/relations). Pick the matching package.'),
                        Forms\Components\Select::make('custom_preset')
                            ->label('Custom preset')
                            ->options([
                                'blank' => 'Blank — build from scratch',
                                'copy' => 'Copy — clone an existing site',
                            ])
                            ->helperText('Only for Custom Plan orders. "Blank" = built from scratch. "Copy" = clone the site at Copy source url. Leave empty for normal plans.'),
                        Forms\Components\TextInput::make('copy_source_url')
                            ->maxLength(500)
                            ->helperText('Only when preset = Copy: the website URL to clone/reference. Leave empty otherwise.'),
                        Forms\Components\Textarea::make('custom_config')
                            ->columnSpanFull()
                            ->helperText('Custom Plan spec as JSON. Keys: pages (number), maintenance (months), features (list of strings). Example: {"pages":5,"maintenance":3,"features":["SEO","Blog"]}. Leave empty for normal plans.'),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->helperText('Free notes about this order/project. Internal — not shown to client.'),
                    ])->columns(2),

                Forms\Components\Section::make('Project Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'On Progress' => 'On Progress',
                                'Staging Ready' => 'Staging Ready',
                                'Completed' => 'Completed',
                            ])->required(),
                        Forms\Components\Select::make('project_stage')
                            ->options([
                                'pending' => 'Pending',
                                'design' => 'Design',
                                'development' => 'Development',
                                'qa' => 'QA',
                                'delivered' => 'Delivered',
                                'closed' => 'Closed',
                            ])->required(),
                        Forms\Components\TextInput::make('staging_url')->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Invoice')
                    ->schema([
                        Forms\Components\TextInput::make('invoice_number')->required()->maxLength(50),
                        Forms\Components\Select::make('invoice_currency')
                            ->options(['IDR' => 'IDR', 'USD' => 'USD'])->required(),
                        Forms\Components\Select::make('invoice_status')
                            ->options([
                                'draft' => 'Draft',
                                'sent' => 'Sent',
                                'paid' => 'Paid',
                                'void' => 'Void',
                            ])->required(),
                        Forms\Components\Select::make('invoice_sent')
                            ->options([
                                'pending' => 'Pending',
                                'sent' => 'Sent',
                                'failed' => 'Failed',
                            ])->required(),
                        Forms\Components\TextInput::make('invoice_amount')->numeric(),
                        Forms\Components\DatePicker::make('invoice_due_date'),
                        Forms\Components\TextInput::make('package_price')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('addons_total')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('final_price')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('payment_method')->maxLength(50)->default('Bank Transfer'),
                        Forms\Components\TextInput::make('referral_code')->maxLength(20),
                        Forms\Components\Textarea::make('invoice_notes')
                            ->columnSpanFull()
                            ->helperText('Free-text notes printed on the invoice PDF (terms, payment instructions, etc.).'),
                        Forms\Components\Textarea::make('invoice_line_items')
                            ->columnSpanFull()
                            ->helperText('Optional JSON array of invoice rows, stored on the order. Suggested shape: [{"description":"Pro Plan","qty":1,"price":5000000}]. Currently stored only (no template renders it yet) — safe to leave empty.'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('order_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('package')->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'Pending',
                        'primary' => 'On Progress',
                        'info' => 'Revision',
                        'success' => 'Done',
                        'danger' => 'Cancelled',
                    ]),
                Tables\Columns\BadgeColumn::make('invoice_status')
                    ->colors([
                        'danger' => 'Unpaid',
                        'warning' => 'Partial',
                        'success' => 'Paid',
                    ]),
                Tables\Columns\TextColumn::make('final_price')
                    ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'On Progress' => 'On Progress',
                        'Revision' => 'Revision',
                        'Done' => 'Done',
                        'Cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('project_stage')
                    ->options([
                        'kickoff' => 'Kickoff',
                        'design' => 'Design',
                        'development' => 'Development',
                        'review' => 'Review',
                        'launch' => 'Launch',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('generate_token')
                    ->label('Generate Progress Token')
                    ->icon('heroicon-o-key')
                    ->action(function (Order $record, $livewire) {
                        $token = Str::random(64);
                        OrderAccessToken::create([
                            'order_id' => $record->id,
                            'token' => $token,
                        ]);
                        $url = config('app.portal_urls.progress').'/progress?t='.$token;
                        $livewire->js('navigator.clipboard.writeText('.json_encode($url).').catch(()=>{})');
                        Notification::make()
                            ->title('Token generated - URL copied to clipboard')
                            ->body($url)
                            ->success()
                            ->persistent()
                            ->send();
                    }),
                Tables\Actions\Action::make('generate_brief_token')
                    ->label('Generate Brief Token')
                    ->icon('heroicon-o-document-text')
                    ->visible(fn (Order $record) => $record->brief_submitted_at === null)
                    ->action(function (Order $record, $livewire) {
                        $token = Str::random(64);
                        OrderAccessToken::create([
                            'order_id' => $record->id,
                            'token' => $token,
                        ]);
                        $url = config('app.portal_urls.brief').'/brief?t='.$token;
                        $livewire->js('navigator.clipboard.writeText('.json_encode($url).').catch(()=>{})');
                        Notification::make()
                            ->title('Brief token generated - URL copied to clipboard')
                            ->body($url)
                            ->success()
                            ->persistent()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Client')
                ->schema([
                    Infolists\Components\TextEntry::make('order_name')->label('Name'),
                    Infolists\Components\TextEntry::make('email'),
                    Infolists\Components\TextEntry::make('phone_number')->label('Phone'),
                ])->columns(3),

            Infolists\Components\Section::make('Project')
                ->schema([
                    Infolists\Components\TextEntry::make('package'),
                    Infolists\Components\TextEntry::make('status')->badge(),
                    Infolists\Components\TextEntry::make('project_stage')->label('Stage'),
                    Infolists\Components\TextEntry::make('staging_url')->label('Staging URL')->url(fn ($state) => $state)->openUrlInNewTab(),
                    Infolists\Components\TextEntry::make('description')->columnSpanFull(),
                ])->columns(2),

            Infolists\Components\Section::make('Pricing')
                ->schema([
                    Infolists\Components\TextEntry::make('package_price')
                        ->label('Package')
                        ->formatStateUsing(fn ($state, $record) => $record->invoice_currency === 'USD' ? '$'.number_format($state, 2) : 'Rp '.number_format($state, 0, ',', '.')),
                    Infolists\Components\TextEntry::make('addons_total')
                        ->label('Addons')
                        ->formatStateUsing(fn ($state, $record) => $record->invoice_currency === 'USD' ? '$'.number_format($state, 2) : 'Rp '.number_format($state, 0, ',', '.')),
                    Infolists\Components\TextEntry::make('final_price')
                        ->label('Total')
                        ->formatStateUsing(fn ($state, $record) => $record->invoice_currency === 'USD' ? '$'.number_format($state, 2) : 'Rp '.number_format($state, 0, ',', '.')),
                    Infolists\Components\TextEntry::make('invoice_currency')->label('Currency'),
                ])->columns(4),

            Infolists\Components\Section::make('Payments')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('payments')
                        ->schema([
                            Infolists\Components\TextEntry::make('stage')
                                ->label('Stage')
                                ->formatStateUsing(fn ($state) => $state === 'deposit' ? 'Deposit (20%)' : 'Final (80%)'),
                            Infolists\Components\TextEntry::make('invoice_number')->label('Invoice #')->fontFamily('mono')->copyable(),
                            Infolists\Components\TextEntry::make('status')->badge()
                                ->color(fn ($state) => match ($state) {
                                    'paid' => 'success',
                                    'sent' => 'warning',
                                    'overdue' => 'danger',
                                    default => 'gray',
                                }),
                            Infolists\Components\TextEntry::make('amount')
                                ->label('Amount')
                                ->formatStateUsing(fn ($state, $record) => $record->amountFormatted()),
                            Infolists\Components\TextEntry::make('due_date')->date('d M Y')->label('Due'),
                            Infolists\Components\TextEntry::make('paid_at')->dateTime('d M Y')->label('Paid')->placeholder('-'),
                        ])
                        ->columns(6)
                        ->columnSpanFull(),
                ]),

            Infolists\Components\Section::make('Metadata')
                ->schema([
                    Infolists\Components\TextEntry::make('referral_code')->label('Referral')->placeholder('-'),
                    Infolists\Components\TextEntry::make('payment_method')->label('Payment method'),
                    Infolists\Components\TextEntry::make('created_at')->dateTime()->label('Created'),
                ])->columns(3)->collapsed(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderResource\RelationManagers\ProgressNotesRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('package');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
