<?php

namespace App\Filament\Widgets;

use App\Models\ReferralCommission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class UnpaidCommissionsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        [$unpaidCount, $unpaidTotal, $paidTotal] = Cache::remember('widget.unpaid_commissions', 60, fn () => [
            ReferralCommission::where('status', 'unpaid')->count(),
            ReferralCommission::where('status', 'unpaid')->sum('commission_amount'),
            ReferralCommission::where('status', 'paid')->sum('commission_amount'),
        ]);

        return [
            Stat::make('Unpaid Commissions', $unpaidCount)->color($unpaidCount > 0 ? 'danger' : 'success'),
            Stat::make('Unpaid Total (IDR)', 'IDR '.number_format($unpaidTotal, 0, '.', ',')),
            Stat::make('Paid Out (IDR)', 'IDR '.number_format($paidTotal, 0, '.', ',')),
        ];
    }
}
