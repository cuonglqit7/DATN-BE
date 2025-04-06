<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filter = $request->input('filter', 'today');

        $totalMembers = User::count();
        $totalProducts = Product::count();

        $ordersQuery = Order::query();

        // Xác định khoảng thời gian hiện tại và trước đó dựa trên filter
        $currentStart = null;
        $currentEnd = Carbon::now();
        $previousStart = null;
        $previousEnd = null;

        switch ($filter) {
            case 'today':
                $currentStart = Carbon::today();
                $previousStart = Carbon::yesterday();
                $previousEnd = Carbon::yesterday()->endOfDay();
                break;
            case 'week':
                $currentStart = Carbon::now()->startOfWeek();
                $previousStart = Carbon::now()->startOfWeek()->subWeek();
                $previousEnd = Carbon::now()->startOfWeek()->subWeek()->endOfWeek();
                break;
            case 'month':
                $currentStart = Carbon::now()->startOfMonth();
                $previousStart = Carbon::now()->startOfMonth()->subMonth();
                $previousEnd = Carbon::now()->startOfMonth()->subMonth()->endOfMonth();
                break;
            case 'year':
                $currentStart = Carbon::now()->startOfYear();
                $previousStart = Carbon::now()->startOfYear()->subYear();
                $previousEnd = Carbon::now()->startOfYear()->subYear()->endOfYear();
                break;
        }

        $ordersQuery->whereBetween('created_at', [$currentStart, $currentEnd]);

        $topProductsCurrentQuery = OrderItem::query()
            ->selectRaw('products.product_name, SUM(order_items.quantity) as total_sold_current')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$currentStart, $currentEnd])
            ->groupBy('products.product_name')
            ->orderByDesc('total_sold_current');

        $topProductsPreviousQuery = OrderItem::query()
            ->selectRaw('products.product_name, SUM(order_items.quantity) as total_sold_previous')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$previousStart, $previousEnd])
            ->groupBy('products.product_name');

        $totalOrders = $ordersQuery->count();
        $totalSold = $ordersQuery->with('orderItems')->get()->sum(function ($order) {
            return $order->orderItems->sum('quantity');
        });

        $recentOrders = $ordersQuery->with('user')
            ->latest()
            ->limit(10)
            ->get();

        $topProductsCurrent = $topProductsCurrentQuery->limit(10)->get();

        $topProductsPrevious = $topProductsPreviousQuery->pluck('total_sold_previous', 'product_name');

        $topSoldProducts = $topProductsCurrent->map(function ($product) use ($topProductsPrevious) {
            $product->total_sold_previous = $topProductsPrevious[$product->product_name] ?? 0;
            $product->difference = $product->total_sold_current - $product->total_sold_previous;
            return $product;
        });

        $labelText = match ($filter) {
            'today' => 'Hôm nay',
            'week' => 'Tuần',
            'month' => 'Tháng',
            'year' => 'Năm',
            default => 'Không xác định'
        };

        $recentMembers = User::query()
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalMembers',
            'totalProducts',
            'totalOrders',
            'totalSold',
            'recentOrders',
            'topSoldProducts',
            'filter',
            'labelText',
            'recentMembers'
        ));
    }
}
