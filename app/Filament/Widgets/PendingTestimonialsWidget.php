<?php

namespace App\Filament\Widgets;

use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingTestimonialsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $pending  = Testimonial::where('status', 'pending')->count();
        $approved = Testimonial::where('status', 'approved')->count();
        $total    = Testimonial::count();

        return [
            Stat::make('Pending Review', $pending)->color($pending > 0 ? 'warning' : 'success'),
            Stat::make('Approved', $approved)->color('success'),
            Stat::make('Total Testimonials', $total),
        ];
    }
}
