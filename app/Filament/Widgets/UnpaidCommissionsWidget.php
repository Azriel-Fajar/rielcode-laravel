<?php

namespace App\Filament\Widgets;

use App\Models\ReferralCommission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UnpaidCommissionsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        $unpaidCount  = ReferralCommission::where('status', 'unpaid')->count();
        $unpaidTotal  = ReferralCommission::where('status', 'unpaid')->sum('commission_amount');
        $paidTotal    = ReferralCommission::where('status', 'paid')->sum('commission_amount');

        return [
            Stat::make('Unpaid Commissions', $unpaidCount)->color($unpaidCount > 0 ? 'danger' : 'success'),
            Stat::make('Unpaid Total (IDR)', 'IDR ' . number_format($unpaidTotal, 0, '.', ',')),
            Stat::make('Paid Out (IDR)', 'IDR ' . number_format($paidTotal, 0, '.', ',')),
        ];
    }
}
