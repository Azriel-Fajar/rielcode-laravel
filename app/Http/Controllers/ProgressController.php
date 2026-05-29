<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProgressNote;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    private const STAGES = [
        'pending' => ['label' => 'Order Received', 'desc' => 'We have your order.'],
        'design' => ['label' => 'Design',         'desc' => 'Working on the look & feel.'],
        'development' => ['label' => 'Development',    'desc' => 'Building your website.'],
        'qa' => ['label' => 'QA & Review',    'desc' => 'Testing and polishing.'],
        'delivered' => ['label' => 'Delivered',      'desc' => 'Project handed off.'],
    ];

    public function show(Request $request): View
    {
        $row = $request->attributes->get('token.gate.row');
        $order = Order::with('progressNotes')->findOrFail($row->order_id);

        $currentStage = $order->project_stage ?: 'pending';
        if ($currentStage === 'closed') {
            $currentStage = 'delivered';
        }

        $stageKeys = array_keys(self::STAGES);
        $currentIndex = array_search($currentStage, $stageKeys, true) ?: 0;

        $notes = OrderProgressNote::where('order_id', $order->id)
            ->orderByDesc('created_at')
            ->get();

        return view('pages.progress', [
            'order' => $order,
            'token' => $request->query('t'),
            'stages' => self::STAGES,
            'stageKeys' => $stageKeys,
            'currentStage' => $currentStage,
            'currentIndex' => $currentIndex,
            'notes' => $notes,
            'archived' => $row->deactivated_at !== null,
        ]);
    }
}
