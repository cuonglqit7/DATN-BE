@extends('layouts.main')
@section('title', 'Dashboard')
@section('navbar')
    <x-component-navbar active="home" />
@endsection
@section('content')
    <div class="mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Xin chào, {{ auth()->user()->name }} 👋</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <span class="mr-2">🔔</span>
                    <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-full">
                    <span class="ml-2 text-gray-800">Robert Fox</span>
                    <span class="ml-2">▼</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <span class="text-3xl mr-4">👥</span>
                    <div>
                        <p class="text-gray-600">Số lượng thành viên</p>
                        <p class="text-2xl font-bold">{{ $totalMembers }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <span class="text-3xl mr-4">📦</span>
                    <div>
                        <p class="text-gray-600">Số lượng sản phẩm</p>
                        <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <span class="text-3xl mr-4">📋</span>
                    <div>
                        <p class="text-gray-600">Số lượng đơn hàng của {{$labelText}}</p>
                        <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <span class="text-3xl mr-4">📈</span>
                    <div>
                        <p class="text-gray-600">Số lượng đã bán của {{$labelText}}</p>
                        <p class="text-2xl font-bold">{{ $totalSold }}</p>
                    </div>
                </div>
            </div>
        </div>

         <div class="mb-4">
            <form method="GET" action="{{ route('home') }}" class="flex items-center space-x-4">
                <div>
                    <label for="filter" class="text-gray-600">Xem theo:</label>
                    <select name="filter" id="filter" class="border rounded p-2" onchange="this.form.submit()">
                        <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hôm nay</option>
                        <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>1 tuần</option>
                        <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>1 tháng</option>
                        <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>1 năm</option>
                    </select>
                </div>
            </form>
        </div>

            
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-semibold mb-4">Top 10 sản phẩm bán chạy trong {{$labelText}}</h3>
            <canvas id="topSoldChart" height="70"></canvas>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Đơn hàng gần đây</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-600">
                            <th class="p-2">Orders ID</th>
                            <th class="p-2">Tên khách hàng</th>
                            <th class="p-2">Ngày đặt</th>
                            <th class="p-2">Tổng tiền đơn hàng</th>
                            <th class="p-2">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td class="p-2">#{{ $order->code }}</td>
                                <td class="p-2">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="p-2">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="p-2">{{ number_format($order->orderItems->sum(fn($item) => $item->unit_price * $item->quantity)) }}</td>
                                <td class="p-2 {{ $order->status === 'Completed' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $order->status }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-2 text-center">Không có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Thành viên mới ({{ $labelText }})</h3>
                <table class="w-full divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="p-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đăng ký</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-gray-200">
                        @forelse ($recentMembers as $member)
                            <tr>
                                <td class="p-2 whitespace-nowrap">{{ $member->email }}</td>
                                <td class="p-2 whitespace-nowrap">{{ $member->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-2 text-center text-gray-500">Không có thành viên mới trong {{ $labelText }}.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('topSoldChart').getContext('2d');
    const topSoldChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topSoldProducts->pluck('product_name')) !!},
            datasets: [
                {
                    label: "{{ $labelText }} này",
                    data: {!! json_encode($topSoldProducts->pluck('total_sold_current')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)', // blue
                    borderRadius: 5
                },
                {
                    label: "{{ $labelText }} trước",
                    data: {!! json_encode($topSoldProducts->pluck('total_sold_previous')) !!},
                    backgroundColor: 'rgba(234, 88, 12, 0.7)', // orange
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false
                },
                legend: {
                    position: 'top'
                }
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    beginAtZero: true,
                    stacked: false,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>


@endpush