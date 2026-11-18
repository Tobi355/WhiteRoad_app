<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $orders = Order::with('user')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->appends($request->only('status'));

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load('items.servicio', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function markAsPaid(Order $order)
    {
        $order->update([
            'status' => 'paid',
            'payment_status' => 'approved',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'La orden fue marcada como pagada.');
    }

    public function markAsCompleted(Order $order)
    {
        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'La orden fue marcada como terminada.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'La orden fue eliminada correctamente.');
    }
}
