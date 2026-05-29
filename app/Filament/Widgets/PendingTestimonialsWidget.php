<?php

namespace App\Filament\Widgets;

use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class PendingTestimonialsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        [$pending, $approved, $total] = Cache::remember('widget.pending_testimonials', 60, fn () => [
            Testimonial::where('status', 'pending')->count(),
            Testimonial::where('status', 'approved')->count(),
            Testimonial::count(),
        ]);

        return [
            Stat::make('Pending Review', $pending)->color($pending > 0 ? 'warning' : 'success'),
            Stat::make('Approved', $approved)->color('success'),
            Stat::make('Total Testimonials', $total),
        ];
    }
}
