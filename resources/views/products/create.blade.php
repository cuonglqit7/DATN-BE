@extends('layouts.main')
@section('title', 'Thêm mới')
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
                            <span class="ms-1 text-sm font-medium text-gray-500">Thêm mới</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <a href="{{ route('products.index') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-xs">Về trước</a>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="mx-auto bg-white p-6">
            <h2 class="text-2xl font-bold mb-4">Thêm Sản Phẩm</h2>
            <ul class="flex border-b">
                <li class="mr-4 flex items-center gap-2 hover:text-gray-500 text-gray-400">
                    <a href="#" class="tab-link active py-2 block" data-tab="0">Thông tin chung</a>
                </li>
                <li class="mr-4 flex items-center gap-2 hover:text-gray-500 text-gray-400">
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m9 5 7 7-7 7" />
                    </svg>
                    <a href="#" class="tab-link px-4 py-2 block" data-tab="1">Thuộc tính sản phẩm</a>
                </li>
                <li class="mr-4 flex items-center gap-2 hover:text-gray-500 text-gray-400">
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m9 5 7 7-7 7" />
                    </svg>
                    <a href="#" class="tab-link px-4 py-2 block" data-tab="2">Hình ảnh & Mô tả</a>
                </li>
                <li class="flex items-center gap-2 hover:text-gray-500 text-gray-400">
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m9 5 7 7-7 7" />
                    </svg>
                    <a href="#" class="tab-link px-4 py-2 block" data-tab="3">Trạng thái & Xác nhận</a>
                </li>
            </ul>

            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="mt-4">
                @csrf
                <!-- Tab 1: Thông tin chung -->
                <div class="tab-content block" id="tab-0">
                    <div class="mb-3">
                        <label for="product_name" class="block font-semibold">Tên sản phẩm</label>
                        <input type="text" id="product_name" value="{{ old('product_name') }}" name="product_name"
                            required class="w-full p-2 border rounded">
                        <p class="text-xs">Tối đa 100 kí tự</p>
                        @error('product_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 flex justify-between gap-2">
                        <div class="mb-3 w-1/2">
                            <label for="price" class="block font-semibold">Giá</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                class="w-full p-2 border rounded">
                            @error('price')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3 w-1/2">
                            <label for="promotion_price" class="block font-semibold">Giá giảm</label>
                            <input type="number" id="promotion_price" name="promotion_price"
                                value="{{ old('promotion_price') }}" class="w-full p-2 border rounded">
                            @error('promotion_price')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="quantity_in_stock" class="block font-semibold">Số lượng</label>
                        <input type="number" id="quantity_in_stock" name="quantity_in_stock"
                            value="{{ old('quantity_in_stock') }}" required class="w-full p-2 border rounded">
                        @error('quantity_in_stock')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 w-1/2 flex gap-2 justify-between items-center mt-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Sản phẩm bán
                                chạy</label>
                            <div class="flex gap-4 mt-1">
                                <label class="flex items-center">
                                    <input type="radio" name="best_selling" value="1"
                                        {{ old('best_selling') == '1' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm">Kích hoạt</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="best_selling" value="0"
                                        {{ old('best_selling') == '0' ? 'checked' : '' }}
                                        class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                    <span class="ml-2 text-sm">Không</span>
                                </label>
                            </div>
                            @error('best_selling')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Sản phẩm nổi
                                bật</label>
                            <div class="flex gap-4 mt-1">
                                <label class="flex items-center">
                                    <input type="radio" name="featured" value="1"
                                        {{ old('featured') == '1' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm">Kích hoạt</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="featured" value="0"
                                        {{ old('featured') == '0' ? 'checked' : '' }}
                                        class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                    <span class="ml-2 text-sm">Không</span>
                                </label>
                            </div>
                            @error('featured')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="block font-semibold">Danh mục</label>
                        <select id="category" name="category" class="w-full p-2 border rounded">
                            <option disabled selected>Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tab 2: Thuộc tính sản phẩm -->
                <div class="tab-content hidden" id="tab-1">
                    <div id="attribute-container">
                        <!-- Mẫu thuộc tính -->
                        <div class="flex gap-2 mb-2 attribute-item">
                            <input type="text" name="attribute_names[]" placeholder="VD: Kích thước"
                                class="w-1/3 p-2 border rounded">
                            <input type="text" name="attribute_values[]" placeholder="VD: 3cm"
                                class="w-1/3 p-2 border rounded">
                            <button type="button" class="text-red-500 px-3 py-1  remove-attribute hidden">x</button>
                        </div>
                        @error('atribute_names')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="add-attribute" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm
                        thuộc tính</button>
                </div>


                <!-- Tab 3: Hình ảnh & Mô tả -->
                <div class="tab-content hidden" id="tab-2">
                    <div class="mb-3">
                        <label for="images" class="block font-semibold">Hình ảnh sản phẩm</label>
                        <input type="file" multiple id="images" name="images[]" accept="image/*"
                            class="w-full p-2 border rounded focus:ring-blue-500" onchange="previewImages(event)">
                        @error('images')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        <!-- Preview Hình Ảnh -->
                        <div id="image-preview" class="grid grid-cols-3 gap-2 mt-2"></div>
                    </div>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="mb-3">
                        <label for="description" class="block font-semibold">Mô tả sản phẩm</label>
                        <textarea id="description" name="description" rows="15" class="w-full p-2 border rounded">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tab 4: Trạng thái & Xác nhận -->
                <div class="tab-content hidden" id="tab-3">
                    <div class="mb-3">
                        <label for="status" class="block font-semibold">Trạng thái hiển thị</label>
                        <select id="status" name="status" class="w-full p-2 border rounded">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let tabs = document.querySelectorAll(".tab-link");
            let contents = document.querySelectorAll(".tab-content");

            tabs.forEach(tab => {
                tab.addEventListener("click", function(event) {
                    event.preventDefault();
                    let tabIndex = this.getAttribute("data-tab");

                    // Xóa trạng thái active của tất cả các tab
                    tabs.forEach(t => t.classList.remove("active", "text-black"));
                    contents.forEach(c => c.classList.add("hidden"));

                    // Kích hoạt tab được chọn
                    this.classList.add("active", "text-black");
                    document.getElementById("tab-" + tabIndex).classList.remove("hidden");
                });
            });

            // Mặc định chọn tab đầu tiên
            tabs[0].click();
        });
    </script>

    <script>
        document.getElementById("add-attribute").addEventListener("click", function() {
            let container = document.getElementById("attribute-container");
            let index = container.getElementsByClassName("attribute-item").length;

            let newAttribute = document.createElement("div");
            newAttribute.classList.add("flex", "gap-2", "mb-2", "attribute-item");
            newAttribute.innerHTML = `
            <input type="text" name="attribute_names[]" placeholder="Tên thuộc tính"
                class="w-1/3 p-2 border rounded" required>
            <input type="text" name="attribute_values[]" placeholder="Giá trị"
                class="w-1/3 p-2 border rounded" required>
            <button type="button" class="text-red-500 px-3 py-1 remove-attribute">x</button>
        `;

            container.appendChild(newAttribute);
            updateRemoveButtons();
        });

        // Xóa thuộc tính
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-attribute")) {
                event.target.parentElement.remove();
                updateRemoveButtons();
            }
        });

        // Hiển thị/xóa nút 🗑️
        function updateRemoveButtons() {
            let buttons = document.getElementsByClassName("remove-attribute");
            for (let btn of buttons) {
                btn.style.display = buttons.length > 1 ? "inline-block" : "none";
            }
        }
        updateRemoveButtons();
    </script>

    <script>
        function previewImages(event) {
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = ""; // Xóa hình cũ khi chọn lại

            Array.from(event.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add("relative", "border", "p-1", "rounded-lg");

                    imgContainer.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded">
                    <label class="flex items-center gap-2 text-sm mt-1">
                        <input type="radio" name="is_primary" value="${index}" class="text-blue-600 focus:ring-blue-500">
                        Ảnh chính
                    </label>
                `;
                    previewContainer.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endpush
