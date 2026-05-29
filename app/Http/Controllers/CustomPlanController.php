<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomPlanRequest;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageAddon;
use Illuminate\Http\Request;

class CustomPlanController extends Controller
{
    public function create(Request $request)
    {
        $activePreset = in_array($request->query('preset'), ['blank', 'copy']) ? $request->query('preset') : 'blank';

        $incompleteOrder = null;
        if ($request->session()->has('order_id')) {
            $incompleteOrder = Order::find($request->session()->get('order_id'));
        }

        $addons = PackageAddon::visible()->ordered()->get();

        return view('pages.custom-plan', compact('activePreset', 'incompleteOrder', 'addons'));
    }

    public function resume(Request $request)
    {
        if ($request->has('continue')) {
            return redirect()->route('checkout.show');
        }
        if ($request->session()->has('order_id')) {
            Order::where('id', $request->session()->get('order_id'))->delete();
        }
        $request->session()->forget(['order_id', 'custom_total']);

        return redirect()->route('custom-plan.create');
    }

    public function store(StoreCustomPlanRequest $request)
    {
        $pkg = Package::where('package_name', 'Custom Plan')->first();
        $customPreset = $request->input('custom_preset', 'blank');
        $customConfig = $request->input('custom_config');
        $configDecoded = ($customConfig && $customConfig !== 'null') ? json_decode($customConfig, true) : null;

        $order = Order::create([
            'order_name' => $request->input('nama'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone'),
            'package' => 'Custom Plan',
            'package_id' => $pkg?->id ?? 0,
            'custom_preset' => $customPreset,
            'copy_source_url' => $request->input('copy_source_url'),
            'custom_config' => $configDecoded,
            'description' => $request->input('additional', ''),
            'status' => 'Pending',
            'invoice_number' => '',
        ]);

        $customTotal = max(500000, (int) $request->input('custom_total', 500000));
        $request->session()->put('order_id', $order->id);
        $request->session()->put('custom_total', $customTotal);

        return redirect()->route('checkout.show');
    }
}
