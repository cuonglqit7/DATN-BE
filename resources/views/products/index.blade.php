@extends('layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('navbar')
    <x-component-navbar active="product" />
@endsection
@section('content')
    <div class="max-w-7xl mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
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
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách sản
                                phẩm</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        @if ($notifications)
            <div class="space-y-3">
                @if ($notifications['quantity_in_tock'])
                    @foreach ($notifications['quantity_in_tock'] as $index => $notification)
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
                            <form action="{{ route('products.edit', $index) }}" method="GET">
                                @csrf
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-3 py-2 rounded transition duration-300">
                                    Giải quyết
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif

            </div>
        @endif

        <div class="flex justify-between align-center ">
            <div class="flex justify-start items-center gap-2">
                <form id="bulk-feature-form" action="{{ route('products.toggleOn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_ids" id="bulk-feature-input">
                    <input type="hidden" name="fields" value="featured">
                    <button type="button"
                        class="bulk-action-btn bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-xs"
                        data-target="bulk-feature-input">
                        Đánh dấu nổi bật
                    </button>
                </form>

                <form id="bulk-best-selling-form" action="{{ route('products.toggleOn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_ids" id="bulk-best-selling-input">
                    <input type="hidden" name="fields" value="best_selling">
                    <button type="button"
                        class="bulk-action-btn bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-xs"
                        data-target="bulk-best-selling-input">
                        Đánh dấu bán chạy
                    </button>
                </form>

                <form id="bulk-status-form" action="{{ route('products.toggleOn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_ids" id="bulk-status-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-xs"
                        data-target="bulk-status-input">
                        Hiển thị
                    </button>
                </form>

                <form id="bulk-status-off-form" action="{{ route('products.toggleOff') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_ids" id="bulk-status-off-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 text-xs"
                        data-target="bulk-status-off-input">
                        Tạm ẩn
                    </button>
                </form>
            </div>

            <form action="{{ route('products.index') }}" method="POST"
                class="flex flex-wrap justify-end items-center gap-2 my-4">
                @csrf
                @method('GET')
                <div>
                    <select id="record_number" name="record_number"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" {{ old('record_number', $numperpage) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ old('record_number', $numperpage) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ old('record_number', $numperpage) == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ old('record_number', $numperpage) == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>
                <input type="text" name="product_name" placeholder="Tìm kiếm"
                    value="{{ old('product_name', request('product_name')) }}" class="border rounded p-2 text-sm" />
                <button type="submit"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Tìm</button>
                <a href="{{ route('products.index') }}"
                    class="bg-gray-400 text-white px-3 py-2 rounded hover:bg-gray-500 text-xs">Xóa lọc</a>
                @can('product-create')
                    <a href="{{ route('products.create') }}"
                        class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Thêm mới</a>
                @endcan
            </form>

        </div>

        <table class="w-full rtl:text-right border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th class="p-2 max-w-24">Tên sản phẩm</th>
                    <th class="p-2 ps-3">Giá cả</th>
                    <th class="p-2">Danh mục</th>
                    <th class="p-2">Tồn kho</th>
                    <th class="p-2">Số sao</th>
                    <th class="p-2">Đã bán</th>
                    <th class="p-2 text-center">Bán chạy</th>
                    <th class="p-2 text-center">Nổi bật</th>
                    <th class="p-2">Trạng thái</th>
                    <th class="p-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-t hover:bg-gray-100 transition-all duration-200 even:bg-gray-50">
                        <td class="p-2 text-left">
                            <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                class="accent-blue-500 product-checkbox">
                        </td>
                        <td class="p-1 max-w-24 overflow-hidden text-ellipsis whitespace-nowrap">
                            <a href="{{ route('products.show', $product->slug) }}" title="{{ $product->product_name }}"
                                class="font-semibold text-blue-600 hover:underline">{{ $product->product_name }}</a>
                        </td>
                        <td class="p-1 ps-3">
                            @if ($product->price == $product->promotion_price)
                                {{ number_format($product->price, 0, ',', '.') }} VNĐ
                            @else
                                <del>{{ number_format($product->price, 0, ',', '.') }} VNĐ</del> <br>

                                <span
                                    class="text-red-600 font-medium">{{ number_format($product->promotion_price, 0, ',', '.') }}
                                    VNĐ</span>
                            @endif

                        </td>

                        <td class="p-1 ps-3">{{ $product->category->category_name }}</td>
                        <td class="p-1 ps-3">{{ $product->quantity_in_stock }}</td>
                        <td class="p-1 ps-3">{{ number_format($product->product_reviews_avg_rating, 0) }}⭐</td>
                        <td class="p-1 ps-3"><span class="text-red-600 font-medium">{{ $product->quantity_sold }}</span>
                        </td>
                        <td class="p-1 ps-3">
                            @can('product-edit')
                                <form action="{{ route('products.toggleBestSelling', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center justify-center mb-4">
                                        <input type="checkbox" value="" onchange="this.form.submit()"
                                            {{ $product->best_selling ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </form>
                            @endcan
                        </td>
                        <td>
                            @can('product-edit')
                                <form action="{{ route('products.toggleFeatured', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center justify-center mb-4">
                                        <input type="checkbox" value="" onchange="this.form.submit()"
                                            {{ $product->featured ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </form>
                            @endcan
                        </td>
                        <td class="p-1 ps-3">
                            @can('product-edit')
                                <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="status" class="sr-only peer"
                                            {{ $product->status ? 'checked' : '' }} onchange="this.form.submit()">

                                        <div
                                            class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 
                                            peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 
                                            peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                            peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 
                                            after:start-[2px] after:bg-white after:border-gray-300 after:border 
                                            after:rounded-full after:h-5 after:w-5 after:transition-all 
                                            dark:border-gray-600 peer-checked:bg-green-600 dark:peer-checked:bg-green-600">
                                        </div>

                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ $product->status ? 'Hiển thị' : 'Ẩn' }}
                                        </span>
                                    </label>
                                </form>
                            @endcan
                        </td>

                        <td class="p-1 flex gap-2 justify-start">
                            @can('product-edit')
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="p-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-white transition-all">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endcan
                            {{-- @can('product-delete')
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 bg-red-500 hover:bg-red-600 rounded-full text-white transition-all">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" />
                                        </svg>
                                    </button>
                                </form>
                            @endcan --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phần phân trang -->
        <div class="mt-1">
            {{ $products->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const productCheckboxes = document.querySelectorAll(".product-checkbox");

            const selectAllCheckbox = document.getElementById("selectAll");
            selectAllCheckbox.addEventListener("change", function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            document.querySelectorAll(".bulk-action-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const targetInputId = this.dataset.target;
                    const targetInput = document.getElementById(targetInputId);

                    const selectedIds = Array.from(productCheckboxes)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.value);

                    if (selectedIds.length === 0) {
                        alert("Vui lòng chọn ít nhất một sản phẩm.");
                        return;
                    }

                    targetInput.value = selectedIds.join(",");

                    this.closest("form").submit();
                });
            });
        });
    </script>

    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
            };

            toastr.success("{{ session('success') }}", "Thành công 🎉");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endpush
