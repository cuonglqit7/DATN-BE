@extends('layouts.main')
@section('title', 'Danh sách khuyến mãi')
@section('navbar')
    <x-component-navbar active="promo" />
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
                                mã khuyến mãi</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        @if ($notifications)
            <div class="space-y-3">
                @foreach ($notifications as $index => $notification)
                    <div class="flex items-center justify-between bg-red-50 p-3 rounded-lg shadow-md">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-yellow-500 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <span class="font-semibold">{{ $notification }}</span>
                        </div>
                        <form action="{{ route('discounts.toggleOn', $index) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-3 py-2 rounded transition duration-300">
                                Kích hoạt lại
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="flex flex-wrap justify-between items-center gap-4 p-4 bg-white mt-4">
            <!-- Bulk Actions -->
            <div class="flex gap-2">
                <form id="bulk-status-form" action="{{ route('discounts.toggleBulkOn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="discount_ids" id="bulk-status-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-xs"
                        data-target="bulk-status-input">
                        Kích hoạt
                    </button>
                </form>
                <form id="bulk-status-off-form" action="{{ route('discounts.toggleBulkOff') }}" method="POST">
                    @csrf
                    <input type="hidden" name="discount_ids" id="bulk-status-off-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 text-xs"
                        data-target="bulk-status-off-input">
                        Tạm ẩn
                    </button>
                </form>
            </div>

            <!-- Filters and Actions -->
            <form action="{{ route('discounts.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
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
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Sắp diễn ra
                        </option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động
                        </option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Đã hết hạn</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tạm ẩn</option>
                    </select>

                </div>

                <div>
                    <label for="start_date" class="sr-only">Ngày bắt đầu</label>
                    <input type="date" name="start_date" value="{{ old('start_date', request('start_date')) }}"
                        class="border border-gray-300 rounded-md p-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="end_date" class="sr-only">Ngày kết thúc</label>
                    <input type="date" name="end_date" value="{{ old('end_date', request('end_date')) }}"
                        class="border border-gray-300 rounded-md p-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label for="name" class="sr-only">Tìm kiếm</label>
                    <input type="text" name="name" placeholder="Nhập mã khuyến mãi..."
                        value="{{ old('name', request('name')) }}"
                        class="border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-3 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">Tìm</button>
                <a href="{{ route('discounts.index') }}"
                    class="bg-gray-400 text-white px-3 py-2 rounded-md shadow-sm hover:bg-gray-500 transition">Xóa lọc</a>
                <a href="{{ route('discounts.create') }}"
                    class="bg-green-500 text-white px-3 py-2 rounded-md shadow-sm hover:bg-green-600 transition">Thêm
                    mới</a>
            </form>
        </div>

        <table class="w-full border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2"><input type="checkbox" id="selectAll"
                            class="accent-blue-500 hover:cursor-pointer">
                    </th>
                    <th class="p-1">Mã</th>
                    <th class="p-1">Phúc lợi</th>
                    <th class="p-1">Loại khuyến mãi</th>
                    <th class="p-1 text-left">Giá trị</th>
                    <th class="p-1 text-center">Số lần sử dụng</th>
                    <th class="p-2 text-center">Ngày bắt đầu</th>
                    <th class="p-2 text-center">Ngày kết thúc</th>
                    <th class="p-2 flex gap-2 justify-center items-center">Trạng thái
                        <form action="{{ route('discounts.updateStatus') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit">
                                <svg class="w-6 h-6 text-green-500 dark:text-white hover:text-green-300"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                </svg>
                            </button>
                        </form>
                    </th>
                    <th class="p-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts as $item)
                    <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                        <td class="p-2 text-left">
                            <input type="checkbox" name="discount_ids[]" value="{{ $item->id }}"
                                class="accent-blue-500 discounts-checkbox">
                        </td>
                        <td class="p-1 max-w-[300px] font-medium">
                            {{ $item->code }}
                        </td>
                        <td class="p-1 max-w-[300px]">
                            {{ $item->description }}
                        </td>
                        <td class="p-1">
                            <p class="line-clamp-2">{{ $item->discount_type ?? 'Không có' }}</p>
                        </td>
                        <td class="p-1 text-left">
                            <p class="line-clamp-2">
                                @if ($item->discount_type == 'Percentage')
                                    {{ number_format($item->discount_value, 0) }} %
                                @elseif ($item->discount_type == 'Fixed Amount')
                                    {{ number_format($item->discount_value, 0) }} VNĐ
                                @endif
                            </p>
                        </td>
                        <td class="p-1 text-center">
                            {{ $item->numper_usage }}
                        </td>
                        <td class="p-2 text-center text-green-500 font-medium">
                            {{ Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}
                        </td>
                        <td class="p-2 text-center text-red-500 font-medium">
                            {{ Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}
                        </td>
                        <td class="p-1 text-center">
                            @if ($item->status == 'active')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-green-400 border border-green-400">Đang
                                    hoạt động</span>
                            @elseif ($item->status == 'expired')
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-red-400 border border-red-400">Đã
                                    hết hạn</span>
                            @elseif ($item->status == 'upcoming')
                                <span
                                    class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-indigo-400 border border-indigo-400">Sắp
                                    diễn ra</span>
                            @elseif ($item->status == 'inactive')
                                <span
                                    class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300 border border-gray-300">Tạm
                                    ẩn</span>
                            @endif
                        </td>
                        <td class="p-1 flex justify-center gap-1">
                            <a href="{{ route('discounts.edit', $item->id) }}" title="Chỉnh sửa"
                                class="flex justify-center items-center">
                                <svg class="w-6 h-6 text-yellow-600 hover:text-yellow-500 dark:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>
                            <form action="{{ route('discounts.toggleOff', $item->id) }}" method="POST" class="inline"
                                title="Tạm ẩn">
                                @csrf
                                @method('PATCH')
                                <button type="submit">
                                    <svg class="w-6 h-6 text-red-500 hover:text-red-300 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </form>
                            <form action="{{ route('discounts.toggleOn', $item->id) }}" method="POST" class="inline"
                                title="Kích hoạt">
                                @csrf
                                @method('PATCH')
                                <button type="submit">
                                    <svg class="w-6 h-6 text-green-500 hover:text-green-300 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phần phân trang -->
        <div class="mt-1">
            {{ $discounts->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const categoryCheckBoxs = document.querySelectorAll(".discounts-checkbox");

            const selectAllCheckbox = document.getElementById("selectAll");
            selectAllCheckbox.addEventListener("change", function() {
                categoryCheckBoxs.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            document.querySelectorAll(".bulk-action-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const targetInputId = this.dataset.target;
                    const targetInput = document.getElementById(targetInputId);

                    const selectedIds = Array.from(categoryCheckBoxs)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.value);

                    if (selectedIds.length === 0) {
                        alert("Vui lòng chọn ít nhất một danh mục.");
                        return;
                    }

                    targetInput.value = selectedIds.join(",");

                    this.closest("form").submit();
                });
            });
        });
    </script>
    <x-toastr />
@endpush
