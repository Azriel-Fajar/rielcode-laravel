<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatusWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $counts = Order::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $total = array_sum($counts);

        return [
            Stat::make('Total Orders', $total),
            Stat::make('Pending', $counts['Pending'] ?? 0)->color('warning'),
            Stat::make('On Progress', $counts['On Progress'] ?? 0)->color('info'),
            Stat::make('Delivered', $counts['Delivered'] ?? 0)->color('success'),
        ];
    }
}
