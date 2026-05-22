<?php

namespace App\Filament\Widgets;

use App\Models\ChatLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ChatVolumeWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $today = ChatLog::whereDate('created_at', today())->count();
        $week  = ChatLog::where('created_at', '>=', now()->subDays(7))->count();
        $total = ChatLog::count();

        return [
            Stat::make('Chats Today', $today),
            Stat::make('Chats This Week', $week),
            Stat::make('Total Chat Logs', $total),
        ];
    }
}
