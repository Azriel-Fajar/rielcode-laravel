<?php

namespace App\Services;

use App\Models\OrderPayment;
use Illuminate\Support\Facades\Log;

class OverdueScheduler
{
    public function run(): void
    {
        $updated = OrderPayment::where('status', 'sent')
            ->whereDate('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        if ($updated > 0) {
            Log::info("OverdueScheduler: marked {$updated} payment(s) as overdue.");
        }
    }
}
