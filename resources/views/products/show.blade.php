@extends('layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('navbar')
    <x-component-navbar active="product" />
@endsection
@section('content')
    <div class="max-w-7xl mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex items-center mb-5 justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 me-2.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Danh sách sản phẩm
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500">Chi tiết sản phẩm</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <a href="{{ route('products.index') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-xs">Về trước</a>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="w-full">
            <span>Sản phẩm: <h4 class="text-2xl font-bold dark:text-white">{{ $product->product_name }}</h4></span>
            <div class="grid grid-cols-2 gap-4 w-full p-4 border border-gray-300 rounded-lg dark:border-gray-700 mt-3">
                <!-- Cột thông tin -->
                <div>
                    <p class="text-sm font-bold dark:text-white">Danh mục:</p>
                    <p class="text-gray-600 dark:text-gray-300">{{ $product->category->category_name }}</p>

                    <p class="text-sm font-bold mt-2 dark:text-white">Giá gốc:</p>
                    <p class="text-gray-600 dark:text-gray-300">{{ number_format($product->price, 0, ',', '.') }} đ</p>

                    <p class="text-sm font-bold mt-2 dark:text-white">Giá giảm:</p>
                    <p class="text-red-500 font-semibold">
                        {{ $product->promotion_price ? number_format($product->promotion_price, 0, ',', '.') . ' đ' : 'Không có' }}
                    </p>

                    <p class="text-sm font-bold mt-2 dark:text-white">Số lượng tồn kho:</p>
                    <p class="text-gray-600 dark:text-gray-300">{{ $product->quantity_in_stock }}</p>

                    <p class="text-sm font-bold mt-2 dark:text-white">Số lượng đã bán:</p>
                    <p class="text-gray-600 dark:text-gray-300">{{ $product->quantity_sold }}</p>
                </div>

                <!-- Cột mô tả -->
                <div>
                    <p class="text-sm font-bold dark:text-white">Mô tả ngắn:</p>
                    <div class="text-gray-600 dark:text-gray-300 border-l-4 border-blue-500 pl-3 mt-1">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
            <div class="w-full p-4 border border-gray-300 rounded-lg dark:border-gray-700 mt-5">
                <!-- Tabs -->
                <div class="flex border-b">
                    <button onclick="showTab('images')" id="tab-images"
                        class="px-4 py-2 text-sm font-semibold border-b-2 border-transparent text-gray-600 dark:text-gray-300 hover:border-blue-500 focus:border-blue-500">
                        Hình ảnh
                    </button>
                    <button onclick="showTab('attributes')" id="tab-attributes"
                        class="px-4 py-2 text-sm font-semibold border-b-2 border-transparent text-gray-600 dark:text-gray-300 hover:border-blue-500 focus:border-blue-500">
                        Thuộc tính
                    </button>

                </div>
                <!-- Nội dung tab hình ảnh (ẩn mặc định) -->
                <div id="content-images" class="p-4">
                    <p class="text-lg font-bold dark:text-white">Quản lý Hình Ảnh Sản Phẩm</p>

                    @if (count($product->images) < 5)
                        <!-- Form thêm ảnh -->
                        <form action="{{ route('productImages.store') }}" class="mb-4" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple required>
                            <button type="submit"
                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Upload</button>
                        </form>
                    @endif



                    <!-- Bảng hình ảnh -->
                    <table class="w-full border border-gray-300 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800">
                                <th class="p-2 border dark:border-gray-600">Hình</th>
                                <th class="p-2 border dark:border-gray-600">Ảnh chính</th>
                                <th class="p-2 border dark:border-gray-600">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="imageTableBody">
                            @foreach ($product->images as $image)
                                <tr class="text-center" id="imageRow-{{ $image->id }}">
                                    <!-- Ảnh sản phẩm -->
                                    <td class="p-2 border dark:border-gray-600">
                                        <img src="{{ asset('storage/' . $image->image_url) }}"
                                            alt="{{ $image->alt_text }}" class="w-24 h-24 object-cover rounded-md border">
                                    </td>

                                    <!-- Checkbox chọn ảnh chính -->
                                    <td class="p-2 border dark:border-gray-600">
                                        <form action="{{ route('productImages.isPrimary', $image->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <input type="radio" name="is_primary" value="{{ $image->id }}"
                                                class="w-5 h-5 cursor-pointer" onchange="this.form.submit()"
                                                {{ $image->is_primary ? 'checked' : '' }}>
                                        </form>

                                    </td>

                                    <!-- Nút Xóa -->
                                    <td class="p-2 border dark:border-gray-600">
                                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Nội dung tab thuộc tính -->
                <div id="content-attributes" class="p-4">
                    <p class="text-sm font-bold dark:text-white">Danh sách thuộc tính:</p>
                    <ul class="list-disc pl-5 text-gray-600 dark:text-gray-300">
                        @foreach ($product->attributes as $attribute)
                            <li><strong>{{ $attribute->attribute_name }}</strong>: {{ $attribute->attribute_value }}</li>
                        @endforeach
                    </ul>
                </div>


            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function showTab(tabName) {
            // Ẩn tất cả nội dung
            document.getElementById("content-attributes").classList.add("hidden");
            document.getElementById("content-images").classList.add("hidden");

            // Xóa active của tất cả tab
            document.getElementById("tab-attributes").classList.remove("border-blue-500", "text-blue-500");
            document.getElementById("tab-images").classList.remove("border-blue-500", "text-blue-500");

            // Hiển thị nội dung của tab được chọn
            document.getElementById(`content-${tabName}`).classList.remove("hidden");

            // Thêm class active cho tab được chọn
            document.getElementById(`tab-${tabName}`).classList.add("border-blue-500", "text-blue-500");
        }

        // Mặc định hiển thị tab "Thuộc tính"
        document.addEventListener("DOMContentLoaded", function() {
            showTab('images');
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
