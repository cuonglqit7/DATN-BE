<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 5;
        $orders = Order::query()
            ->when($request->name, function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->name . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', 'like', '%' . $request->status . '%');
            })
            ->when($request->order_date, function ($query) use ($request) {
                $query->where('order_date', '>=',  $request->order_date);
            })
            ->orderBy('id', 'desc')
            ->paginate($numperpage);
        return view('orders.index', compact('orders', 'numperpage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
