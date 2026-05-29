<?php

namespace App\Filament\Pages;

use App\Models\AuditLog as AuditLogModel;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditLog extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Audit Log';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.audit-log';

    public function table(Table $table): Table
    {
        return $table
            ->query(AuditLogModel::query()->latest('id'))
            ->columns([
                TextColumn::make('id')->sortable()->label('ID'),
                TextColumn::make('created_at')->dateTime('Y-m-d H:i:s')->sortable()->label('Time'),
                TextColumn::make('event_code')->searchable()->badge()->label('Event'),
                TextColumn::make('severity')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'critical' => 'danger',
                        'warning' => 'warning',
                        'info' => 'success',
                        default => 'gray',
                    })
                    ->label('Severity'),
                TextColumn::make('actor')->searchable()->limit(24)->label('Actor'),
                TextColumn::make('ip_address')->label('IP')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ref_table')->label('Table')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('message')->limit(60)->wrap()->label('Message'),
            ])
            ->filters([
                Filter::make('event_code')
                    ->form([
                        TextInput::make('event_prefix')->label('Event prefix')->placeholder('e.g. ADMIN_'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when($data['event_prefix'], fn ($q, $v) => $q->where('event_code', 'like', $v.'%'))
                    ),
                SelectFilter::make('severity')
                    ->options([
                        'info' => 'Info',
                        'warning' => 'Warning',
                        'critical' => 'Critical',
                    ]),
                Filter::make('actor')
                    ->form([
                        TextInput::make('actor_substring')->label('Actor contains'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when($data['actor_substring'], fn ($q, $v) => $q->where('actor', 'like', '%'.$v.'%'))
                    ),
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
                            ->when($data['until'], fn ($q, $v) => $q->whereDate('created_at', '<=', $v));
                    }),
            ])
            ->headerActions([
                Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn () => $this->exportCsv()),
            ])

            ->striped()
            ->paginated([50, 100, 250])
            ->defaultPaginationPageOption(50)
            ->recordUrl(null);
    }

    public function exportCsv(): StreamedResponse
    {
        $rows = AuditLogModel::query()
            ->latest('id')
            ->limit(5000)
            ->get(['id', 'created_at', 'event_code', 'severity', 'actor', 'ip_address', 'ref_table', 'ref_id', 'message']);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit_log_'.now()->format('Ymd_His').'.csv"',
        ];

        return response()->streamDownload(function () use ($rows) {
            $f = fopen('php://output', 'w');
            fputcsv($f, ['id', 'created_at', 'event_code', 'severity', 'actor', 'ip_address', 'ref_table', 'ref_id', 'message']);
            foreach ($rows as $row) {
                fputcsv($f, $row->toArray());
            }
            fclose($f);
        }, 'audit_log_'.now()->format('Ymd_His').'.csv', $headers);
    }
}
