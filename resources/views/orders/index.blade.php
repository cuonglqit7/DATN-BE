@extends('layouts.main')
@section('title', 'Danh sách đơn hàng')
@section('navbar')
    <x-component-navbar active="order" />
@endsection
@section('content')
    <div class="mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex items-center mb-3 justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách
                                đơn hàng</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="flex flex-wrap justify-end items-center gap-4 py-4 bg-white mt-4">
            <!-- Filters and Actions -->
            <form action="{{ route('orders.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                @csrf

                <div>
                    <label for="record_number" class="sr-only">Số bản ghi</label>
                    <select id="record_number" name="record_number"
                        class="border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" {{ old('record_number', $numperpage) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ old('record_number', $numperpage) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ old('record_number', $numperpage) == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ old('record_number', $numperpage) == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>

                <div>
                    <select id="status" name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
    dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Tất cả</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="Confirm" {{ request('status') == 'Confirm' ? 'selected' : '' }}>Đã xác nhận
                        </option>
                        <option value="Edited" {{ request('status') == 'Edited' ? 'selected' : '' }}>Đã chỉnh sửa</option>
                        <option value="Delivering" {{ request('status') == 'Delivering' ? 'selected' : '' }}>Đang vận chuyển
                        </option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Đã hủy
                        </option>
                    </select>

                </div>

                <div>
                    <label for="order_date" class="sr-only">Lọc theo ngày</label>
                    <input type="date" name="order_date" value="{{ old('order_date', request('order_date')) }}"
                        class="border border-gray-300 rounded-md p-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label for="name" class="sr-only">Tìm kiếm</label>
                    <input type="text" name="name" placeholder="Tìm theo mã đơn hàng..."
                        value="{{ old('name', request('name')) }}"
                        class="border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-3 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">Tìm</button>
                <a href="{{ route('orders.index') }}"
                    class="bg-gray-400 text-white px-3 py-2 rounded-md shadow-sm hover:bg-gray-500 transition">Xóa lọc</a>
            </form>
        </div>

        <table class="w-full border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">Mã đơn hàng</th>
                    <th class="p-1">Tài khoản</th>
                    <th class="p-1">Ngày đặt</th>
                    <th class="p-1 text-left">Tổng tiền</th>
                    <th class="p-2 text-left">Khách hàng nhận</th>
                    <th class="p-2 text-left">Ghi chú</th>
                    <th class="p-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                        <td class="p-2 max-w-[300px]">
                            <a href="{{ route('orders.show', $item->id) }}"
                                class="font-semibold text-blue-600 hover:underline"
                                title="Xem chi tiết đơn hàng {{ $item->code }}">
                                #{{ $item->code }}
                            </a>
                        </td>
                        <td class="p-1 max-w-[300px]">
                            {{ $item->user->email }}
                        </td>
                        <td class="p-1">
                            {{ date('H:i d-m-Y', strtotime($item->order_date)) }}
                        </td>

                        <td class="p-1 text-left">
                            {{ number_format($item->total_price, 0) }} đ
                        </td>
                        <td class="p-2 text-left">
                            {{ $item->recipient_name }}
                        </td>
                        <td class="p-2 text-left">
                            {{ $item->user_note }}
                        </td>
                        <td class="p-1 flex justify-center gap-1">
                            <div class="max-w-sm mx-auto bg-white p-4 text-center">
                                <span class="text-sm font-medium text-gray-700">Trạng thái đơn hàng:</span>
                                <div class="flex justify-center gap-2 mt-2">
                                    @if ($item->status == 'Pending')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Chờ
                                            xử lý</span>
                                    @elseif ($item->status == 'Confirm')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Đã
                                            xác nhận</span>
                                    @elseif ($item->status == 'Edited')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-800">Đã
                                            chỉnh sửa</span>
                                    @elseif ($item->status == 'Delivering')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">Đang
                                            vận chuyển</span>
                                    @elseif ($item->status == 'Completed')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Hoàn
                                            tất</span>
                                    @elseif ($item->status == 'Cancelled')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Đã
                                            hủy</span>
                                    @endif
                                    @if ($item->status == 'Cancelled' || $item->status == 'Completed')
                                    @else
                                        <button
                                            class="px-3 py-1 text-xs bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
                                            onclick="document.getElementById('updateModal').classList.remove('hidden')">
                                            Cập nhật
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Modal cập nhật -->
                            <div id="updateModal"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
                                <div class="bg-white p-5 rounded-lg shadow-lg max-w-sm w-full">
                                    <h3 class="text-lg font-semibold">Cập nhật trạng thái</h3>
                                    <form action="{{ route('orders.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class="w-full border-gray-300 rounded-md shadow-sm p-2 mt-2" name="status">
                                            <option value="Confirm">Xác nhận</option>
                                            <option value="Delivering">Đang giao hàng</option>
                                            <option value="Completed">Hoàn thành</option>
                                            <option value="Cancelled">Đã hủy</option>
                                        </select>
                                        <div class="mt-3 flex justify-end gap-2">
                                            <button type="reset" class="px-3 py-1 bg-gray-300 text-gray-700 rounded-lg"
                                                onclick="document.getElementById('updateModal').classList.add('hidden')">Hủy</button>
                                            <button type="submit"
                                                class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phần phân trang -->
        <div class="mt-1">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <x-toastr />
@endpush
