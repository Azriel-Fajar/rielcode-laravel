<?php

namespace App\Http\Controllers;

use App\Models\OrderPayment;
use App\Services\InvoicePdfService;
use App\Services\QrService;
use Illuminate\Http\Request;

class PublicInvoiceController extends Controller
{
    public function show(string $invoiceNumber)
    {
        $payment = OrderPayment::with('order')
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        // Auto-mark overdue on view
        if ($payment->status === 'sent' && $payment->due_date < now()->toDateString()) {
            $payment->update(['status' => 'overdue']);
        }

        $cfg = config('payment');

        return view('pages.invoice.show', compact('payment', 'cfg'));
    }

    public function pdf(string $invoiceNumber, InvoicePdfService $pdfService)
    {
        $payment = OrderPayment::with('order')
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        return $pdfService->download($payment);
    }
}
