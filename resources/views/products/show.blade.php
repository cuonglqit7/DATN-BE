@extends('layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('navbar')
    <x-component-navbar active="product" />
@endsection
@section('content')
    <div class="mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
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
            <a href="{{ url()->previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-xs">Về
                trước</a>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        @if ($notification)
            <div class="space-y-3">
                @if ($notification['quantity_in_tock'])
                    <div class="flex items-center justify-between bg-red-50 p-3 rounded-lg shadow-md">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-yellow-500 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <span class="font-semibold">{{ $notification['quantity_in_tock'] }}</span>
                        </div>
                        <form action="{{ route('products.edit', $product->id) }}" method="GET">
                            @csrf
                            <button
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-3 py-2 rounded transition duration-300">
                                Giải quyết
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        @endif
        <div class="mt-5">
            <div class="flex border-b border-gray-200">
                <button id="tab-details" onclick="showTab('details')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 border-b-2 border-blue-500 focus:outline-none">Chi
                    tiết sản phẩm</button>
                <button id="tab-images" onclick="showTab('images')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:border-b-2 hover:border-blue-500 focus:outline-none">Hình
                    ảnh & Mô tả</button>
                <button id="tab-reviews" onclick="showTab('reviews')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:border-b-2 hover:border-blue-500 focus:outline-none">Đánh
                    giá</button>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div id="content-details" class="p-4">
                <h2 class="text-lg font-semibold mb-3">Thông tin sản phẩm</h2>
                <div class="grid grid-cols-2 gap-4">
                    <p>📦 Tên sản phẩm: {{ $product->product_name }}</p>
                    <p>🔗 Slug: {{ $product->slug }}</p>
                    <p>📊 Số sao: {{ number_format($avgRating, 0) }}⭐</p>
                    <p>💰 Giá gốc: {{ number_format($product->price, 0) }} VND</p>
                    <p>📦 Số lượng trong kho: {{ $product->quantity_in_stock }}</p>
                    <p>🎉 Giá khuyến mãi: {{ number_format($product->promotion_price, 0) }} VND</p>
                    <p>🛒 Đã bán: {{ $product->quantity_sold }}</p>
                    <p>🚀 Sản phẩm bán chạy: {{ $product->best_selling ? 'Kích hoạt' : 'Không kích hoạt' }}
                    </p>
                    <p>🌟 Sản phẩm nổi bật: {{ $product->featured ? 'Kích hoạt' : 'Không kích hoạt' }}</p>
                    <p>🔄 Trạng thái:
                        @if ($product->status == 1)
                            Đang hiển thị
                        @else
                            Đang ẩn
                        @endif
                    </p>
                    <p>📅 Ngày tạo: {{ $product->created_at->format('d/m/Y') }}</p>
                </div>

                <h2 class="text-lg font-semibold mt-6">Các thuộc tính sản phẩm:</h2>
                <div class="overflow-x-auto mt-2">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">⚙️ Thuộc tính</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">🔢 Giá trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->attributes as $attribute)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $attribute->attribute_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $attribute->attribute_value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hình ảnh sản phẩm & Mô tả -->
            <div id="content-images" class="p-4 hidden">
                <h2 class="text-lg font-semibold mb-3">🖼️ Hình ảnh sản phẩm</h2>
                <div class="grid grid-cols-5 gap-4">
                    @foreach ($images->sortByDesc('is_primary') as $image)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $image->alt_text }}"
                                class="w-full h-32 md:h-40 object-cover rounded-lg shadow-md
                                       {{ $image->is_primary ? 'border-2 border-blue-500 brightness-110' : 'hover:brightness-110 transition duration-200' }}">
                            @if ($image->is_primary)
                                <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                    Ảnh chính
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <h2 class="text-lg font-semibold mb-3">📝 Mô tả sản phẩm</h2>
                    <p>{{ $product->description }}</p>
                </div>
            </div>

            <!-- Đánh giá của khách hàng -->
            <div id="content-reviews" class="p-4 hidden">
                <h2 class="text-lg font-semibold mb-3">Đánh giá của khách hàng</h2>
                @if ($productReviews)
                    @foreach ($productReviews as $productReview)
                        <div class="mb-4 p-4 border rounded-lg shadow-sm">
                            <p class="font-semibold">👤 {{ $productReview->user->name }} - {{ $productReview->rating }}/5
                                ⭐
                            </p>
                            <p class="text-gray-600">💬 {{ $productReview->comment }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showTab(tabName) {
            let tabs = ["details", "images", "reviews"];
            tabs.forEach(tab => {
                document.getElementById(`content-${tab}`).classList.add("hidden");
                document.getElementById(`tab-${tab}`).classList.remove("border-b-2", "border-blue-500");
            });

            document.getElementById(`content-${tabName}`).classList.remove("hidden");
            document.getElementById(`tab-${tabName}`).classList.add("border-b-2", "border-blue-500");
        }
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
@endpush)
