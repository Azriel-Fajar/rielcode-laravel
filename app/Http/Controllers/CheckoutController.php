<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\OrderAccessToken;
use App\Models\Package;
use App\Models\Referrer;
use App\Models\ReferralCommission;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        if (!$request->session()->has('order_id')) {
            return redirect()->route('order.create');
        }

        $order = Order::find($request->session()->get('order_id'));
        if (!$order) {
            return redirect()->route('order.create')->withErrors(['order' => 'RC-ORDER-001: Order not found.']);
        }

        $pkg = Package::where('package_name', $order->package)->first();
        if (!$pkg) {
            return redirect()->route('order.create')->withErrors(['order' => 'RC-ORDER-002: Package not found.']);
        }

        [$packagePrice, $discountPrice, $displayOriginal] = $this->calcPricing($order, $pkg, $request);

        $referralError = '';
        $rawCode = '';
        if ($request->isMethod('post')) {
            $rawCode = trim($request->input('referral_code', ''));
        }

        return view('pages.checkout', [
            'order'          => $order,
            'pkg'            => $pkg,
            'packagePrice'   => $packagePrice,
            'discountPrice'  => $discountPrice,
            'displayOriginal' => $displayOriginal,
            'referralError'  => $referralError,
            'rawCode'        => $rawCode,
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate(['terms' => 'accepted']);

        if (!$request->session()->has('order_id')) {
            return redirect()->route('order.create');
        }

        $order = Order::find($request->session()->get('order_id'));
        if (!$order) {
            return redirect()->route('order.create');
        }
        if (in_array($order->status, ['On Progress', 'Staging Ready', 'Completed'])) {
            $request->session()->forget('order_id');
            return redirect()->route('order.create')->with('info', 'Order already confirmed.');
        }

        $pkg = Package::where('package_name', $order->package)->first();
        if (!$pkg) {
            return redirect()->route('order.create');
        }

        [$packagePrice, $discountPrice] = $this->calcPricing($order, $pkg, $request);
        $finalPrice = $packagePrice;

        $rawCode = trim($request->input('referral_code', ''));
        $referrer = null;
        if ($rawCode !== '') {
            $referrer = Referrer::where('code', $rawCode)->where('status', 'active')->first();
            if (!$referrer) {
                return back()->withInput()->with('referralError', 'This code is invalid or inactive.');
            }
        }

        // Update package order count
        $pkg->increment('orders');

        // Set order to On Progress
        $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . $order->id;
        $order->update([
            'status'           => 'On Progress',
            'package_price'    => $packagePrice,
            'addons_total'     => 0,
            'final_price'      => $finalPrice,
            'invoice_number'   => $invoiceNumber,
            'invoice_status'   => 'draft',
            'invoice_amount'   => $finalPrice,
            'invoice_currency' => 'IDR',
        ]);

        if ($referrer) {
            $order->update(['referral_code' => $rawCode]);
            $commissionAmount = round($finalPrice * ($referrer->commission_rate / 100), 2);
            ReferralCommission::create([
                'referrer_id'       => $referrer->id,
                'order_id'          => $order->id,
                'order_amount'      => $finalPrice,
                'commission_amount' => $commissionAmount,
            ]);
        }

        // Generate progress token
        $progressToken = bin2hex(random_bytes(32));
        OrderAccessToken::create([
            'order_id' => $order->id,
            'token'    => $progressToken,
        ]);

        $progressUrl = 'https://progress.rielcode.com/?t=' . $progressToken;

        // Send confirmation email
        try {
            Mail::to($order->email, $order->order_name)->send(new OrderConfirmationMail($order, $progressToken, $progressUrl));
            $order->update(['invoice_sent' => 'pending']);
            AuditLogger::log('PAYMENT_PROOF_RECEIVED', 'info', null, ['order_id' => $order->id, 'plan' => $order->package]);
        } catch (\Throwable $e) {
            AuditLogger::log('PAYMENT_EMAIL_FAIL', 'error', null, ['order_id' => $order->id, 'err' => $e->getMessage()]);
        }

        $request->session()->put('progress_token', $progressToken);
        $request->session()->put('progress_order_id', $order->id);
        $request->session()->forget('order_id');
        $request->session()->forget('custom_total');

        return redirect()->route('checkout.success');
    }

    public function success(Request $request)
    {
        $progressToken  = $request->session()->get('progress_token');
        $progressOrderId = $request->session()->get('progress_order_id');
        $progressUrl     = $progressToken ? 'https://progress.rielcode.com/?t=' . $progressToken : null;

        $request->session()->forget(['progress_token', 'progress_order_id', 'order_id', 'custom_total']);

        return view('pages.checkout-success', compact('progressUrl', 'progressToken', 'progressOrderId'));
    }

    private function calcPricing(Order $order, Package $pkg, Request $request): array
    {
        if ($order->package === 'Custom Plan') {
            $packagePrice    = (int) $request->session()->get('custom_total', 500000);
            $discountPrice   = 0;
            $displayOriginal = $packagePrice;
        } else {
            $displayOriginal = $pkg->idr_price * 2;
            $discountPrice   = $displayOriginal * 0.5;
            $packagePrice    = $displayOriginal - $discountPrice;
        }
        return [(int) $packagePrice, (int) $discountPrice, (int) $displayOriginal];
    }
}
