<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    public function generate(string $stage): string
    {
        $suffix = $stage === 'deposit' ? 'D' : 'F';
        $year   = (int) date('Y');

        DB::statement("
            INSERT INTO invoice_counter (year, last_number)
            VALUES (?, 1)
            ON DUPLICATE KEY UPDATE last_number = last_number + 1
        ", [$year]);

        $counter = DB::selectOne('SELECT last_number FROM invoice_counter WHERE year = ?', [$year]);

        return sprintf('INV-%d-%03d-%s', $year, (int) $counter->last_number, $suffix);
    }
}
