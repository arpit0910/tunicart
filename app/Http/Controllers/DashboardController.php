<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->get();
            
        $activeDesignsCount = 0;
        foreach($orders as $order) {
            foreach($order->items as $item) {
                if ($item->front_image || $item->back_image) {
                    $activeDesignsCount++;
                }
            }
        }
            
        $stats = [
            'total_orders' => $orders->count(),
            'active_designs' => $activeDesignsCount
        ];

        return view('dashboard', [
            'orders' => $orders,
            'stats' => $stats
        ]);
    }

    public function designs()
    {
        $designs = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->where('user_id', auth()->id());
        })->where(function($q) {
            $q->whereNotNull('front_mockup')->orWhereNotNull('back_mockup');
        })->with('product')->latest()->get();

        return view('pages.custom-designs', compact('designs'));
    }
}
