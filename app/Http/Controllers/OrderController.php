<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageAddon;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $aksiMap = [
            'landing'  => 'Student Plan',
            'starter'  => 'Starter Plan',
            'pro'      => 'Pro Plan',
            'business' => 'Premium Plan',
            'custom'   => 'Custom Plan',
        ];

        $selectedSlug = $request->query('aksi', '');
        $defaultPlan = $aksiMap[$selectedSlug] ?? '';
        $packages = Package::where('is_visible', true)->where('slug', '!=', 'custom')->orderBy('sort_order')->get();
        $addons = PackageAddon::where('is_visible', true)->orderBy('sort_order')->get();

        $incompleteOrder = null;
        if ($request->session()->has('order_id')) {
            $incompleteOrder = Order::find($request->session()->get('order_id'));
        }

        return view('pages.order.form', compact('defaultPlan', 'selectedSlug', 'packages', 'addons', 'incompleteOrder'));
    }

    public function resume(Request $request)
    {
        if ($request->has('continue')) {
            return redirect()->route('checkout.show');
        }
        if ($request->session()->has('order_id')) {
            Order::where('id', $request->session()->get('order_id'))->delete();
        }
        $request->session()->forget(['order_id', 'custom_total', 'selected_addons']);
        return redirect()->route('order.create');
    }

    public function store(StoreOrderRequest $request)
    {
        $package = $request->input('package');

        $pkg = Package::where('package_name', $package)->first();
        if (!$pkg) {
            AuditLogger::log('ORDER_REJECTED_PLAN', 'warn', null, ['plan' => $package, 'ip' => $request->ip()]);
            return redirect()->route('order.create')->withErrors(['package' => 'Invalid package selected.']);
        }

        $description = $request->input('additional', '');
        if ($request->boolean('free_promo')) {
            $promoText   = 'Claimed Year-End Promo: Free Hosting & .COM Domain';
            $description = $description ? $description . "\n\n---\n" . $promoText : $promoText;
        }

        $domain  = $package === 'Student Plan' ? 'No' : ($request->input('domain', 'No'));
        $hosting = $package === 'Student Plan' ? 'No' : ($request->input('hosting', 'No'));

        $addonIds = array_filter((array) $request->input('addons', []), 'is_numeric');
        $selectedAddons = [];
        $addonsTotal = 0;

        if (!empty($addonIds)) {
            $addonModels = PackageAddon::whereIn('id', $addonIds)->where('is_visible', true)->get();
            foreach ($addonModels as $a) {
                $selectedAddons[] = [
                    'id'        => $a->id,
                    'name'      => $a->name,
                    'price_idr' => $a->price_idr,
                    'price_usd' => $a->price_usd,
                    'type'      => $a->type,
                ];
                $addonsTotal += $a->price_idr;
            }
        }

        $packagePrice = $pkg->idr_price ?? 0;

        $order = Order::create([
            'order_name'      => $request->input('nama'),
            'email'           => $request->input('email'),
            'phone_number'    => $request->input('phone'),
            'package'         => $package,
            'package_id'      => $pkg->id,
            'owns_domain'     => $domain,
            'owns_hosting'    => $hosting,
            'description'     => $description,
            'status'          => 'Pending',
            'invoice_number'  => '',
            'selected_addons' => $selectedAddons ?: null,
            'package_price'   => $packagePrice,
            'addons_total'    => $addonsTotal,
            'final_price'     => $packagePrice + $addonsTotal,
        ]);

        AuditLogger::log('ORDER_CREATED', 'info', null, ['order_id' => $order->id, 'plan' => $package]);

        $request->session()->put('order_id', $order->id);

        return redirect()->route('checkout.show');
    }
}
