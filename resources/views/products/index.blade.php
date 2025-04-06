@extends('layouts.main')
@section('title', 'Danh sách sản phẩm')
@section('navbar')
    <x-component-navbar active="product" />
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
                @if ($notifications['quantity_in_stock'])
                    @foreach ($notifications['quantity_in_stock'] as $index => $notification)
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
                    <th class="p-2 text-center">Hình</th>
                    <th class="p-2">Tên sản phẩm</th>
                    <th class="p-2 ps-3">Giá cả</th>
                    <th class="p-2">Danh mục</th>
                    <th class="p-2">Tồn kho</th>
                    <th class="p-2">Số sao</th>
                    <th class="p-2">Đã bán</th>
                    <th class="p-2 text-center">Bán chạy</th>
                    <th class="p-2 text-center">Nổi bật</th>
                    <th class="p-2">Trạng thái</th>
                    <th class="p-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-t hover:bg-gray-100 transition-all duration-200 even:bg-gray-50">
                        <td class="p-2 text-left">
                            <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                class="accent-blue-500 product-checkbox">
                        </td>
                        <td class="p-2 w-[60px] text-center">
                            @if($product->images->isNotEmpty())
                                @foreach ($product->images as $item)
                                    
                                    @if ($item->is_primary == true)
                                    <img src="{{ asset('storage/'.$item->image_url) }}" alt="{{ $product->product_name }}" class="w-[60px] h-[60px] object-cover rounded">
                                    @endif
                                @endforeach
                            @else
                                <p>Không có hình ảnh</p>
                            @endif
                        </td>
                        <td class="p-1 overflow-hidden text-ellipsis whitespace-nowrap">
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

                        <td class="p-1 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" title="Chỉnh sửa"
                                    class="flex justify-center items-center">
                                    <svg class="w-6 h-6 text-yellow-600 hover:text-yellow-500 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex justify-center items-center">
                                        <svg class="w-6 h-6 text-gray-800 hover:text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                        </svg>
                                    </button>
                                </form>                                
                            </div>
                        </td>
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
    <x-toastr />
@endpush
