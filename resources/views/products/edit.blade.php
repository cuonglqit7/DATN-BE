@extends('layouts.main')
@section('title', 'Chỉnh sửa - ' . $product->product_name)
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
                            <span class="ms-1 text-sm font-medium text-gray-500">Chỉnh sửa -
                                {{ $product->product_name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <a href="{{ url()->previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-xs">Về
                trước</a>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="mx-auto bg-white p-6">
            <h2 class="text-2xl font-bold mb-4">Chỉnh sửa - {{ $product->product_name }}</h2>

            <div class="flex justify-between border-b p-2">
                <ul class="flex">
                    <li class="mr-4 flex items-center gap-2 hover:text-gray-500 text-gray-400">
                        <a href="#" class="tab-link active py-2 block" data-tab="0">Thông tin chung</a>
                    </li>
                    <li class="mr-4 flex items-center gap-2 hover:text-gray-500 text-gray-400">
                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 5 7 7-7 7" />
                        </svg>
                        <a href="#" class="tab-link px-4 py-2 block" data-tab="1">Thuộc tính sản phẩm</a>
                    </li>
                    <li class="mr-4 flex items-center gap-2 hover:text-gray-500 text-gray-400">
                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 5 7 7-7 7" />
                        </svg>
                        <a href="#" class="tab-link px-4 py-2 block" data-tab="2">Hình ảnh & Mô tả</a>
                    </li>
                    <li class="flex items-center gap-2 hover:text-gray-500 text-gray-400">
                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 5 7 7-7 7" />
                        </svg>
                        <a href="#" class="tab-link px-4 py-2 block" data-tab="3">Trạng thái & Xác nhận</a>
                    </li>
                </ul>
                
            </div>

            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data"
                class="mt-4">
                @method('PATCH')
                @csrf
                <!-- Tab 1: Thông tin chung -->
                <div class="tab-content block" id="tab-0">
                    <div class="mb-3">
                        <label for="product_name" class="block font-semibold">Tên sản phẩm</label>
                        <input type="text" id="product_name" value="{{ $product->product_name }}" name="product_name"
                            required class="w-full p-2 border rounded">
                        <p class="text-xs">Tối đa 100 kí tự</p>
                        @error('product_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 flex justify-between gap-2">
                        <div class="mb-3 w-1/2">
                            <label for="price" class="block font-semibold">Giá</label>
                            <input type="number" id="price" name="price" value="{{ $product->price }}" required
                                class="w-full p-2 border rounded">
                            @error('price')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3 w-1/2">
                            <label for="promotion_price" class="block font-semibold">Giá giảm</label>
                            <input type="number" id="promotion_price" name="promotion_price"
                                value="{{ $product->promotion_price }}" class="w-full p-2 border rounded">
                            @error('promotion_price')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="quantity_in_stock" class="block font-semibold">Số lượng</label>
                        <input type="number" id="quantity_in_stock" name="quantity_in_stock"
                            value="{{ $product->quantity_in_stock }}" required class="w-full p-2 border rounded">
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
                                        {{ $product->best_selling == '1' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm">Kích hoạt</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="best_selling" value="0"
                                        {{ $product->best_selling == '0' ? 'checked' : '' }}
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
                                        {{ $product->featured == '1' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm">Kích hoạt</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="featured" value="0"
                                        {{ $product->featured == '0' ? 'checked' : '' }}
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
                                    {{ $product->category->id == $category->id ? 'selected' : '' }}>
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
                        @foreach ($product->attributes as $item)
                            <div class="flex gap-2 mb-2 attribute-item">
                                <input type="hidden" name="attribute_ids[]" value="{{ $item->id }}">
                                <input type="text" name="attribute_names[]" value="{{ $item->attribute_name }}"
                                    placeholder="VD: Kích thước" class="w-1/3 p-2 border rounded">
                                <input type="text" name="attribute_values[]" value="{{ $item->attribute_value }}"
                                    placeholder="VD: 3cm" class="w-1/3 p-2 border rounded">
                                <button type="button" class="text-red-500 px-3 py-1 remove-attribute">x</button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-attribute" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm thuộc
                        tính</button>
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
                        <div id="image-preview" class="grid grid-cols-3 gap-2 mt-2">
                            @foreach ($product->images as $item)
                                <div class="relative border p-1 rounded-lg" id="image-{{ $item->id }}">
                                    <img src="{{ asset('storage/' . $item->image_url) }}"
                                        class="w-full h-32 object-cover rounded">

                                    <!-- Lưu ID của ảnh cũ -->
                                    <input type="hidden" name="old_images[]" value="{{ $item->id }}">

                                    <label class="flex items-center gap-2 text-sm mt-1">
                                        <input type="radio" name="is_primary" value="{{ $item->id }}"
                                            {{ $item->is_primary ? 'checked' : '' }}
                                            class="text-blue-600 focus:ring-blue-500">
                                        Ảnh chính
                                    </label>

                                    <!-- Nút Xóa Ảnh -->
                                    <button type="button"
                                        class="absolute top-1 right-1 bg-red-500 text-white px-2 py-1 text-xs rounded"
                                        onclick="removeImage({{ $item->id }})">
                                        Xóa
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="mb-3">
                        <label for="description" class="block font-semibold">Mô tả sản phẩm</label>
                        <textarea id="description" name="description" rows="15" class="w-full p-2 border rounded">{{ $product->description }}</textarea>
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
                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật sản phẩm</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("attribute-container");
            const addButton = document.getElementById("add-attribute");

            // Mẫu HTML thuộc tính mới
            function createAttributeItem(id = "", name = "", value = "") {
                return `
            <div class="flex gap-2 mb-2 attribute-item">
                <input type="hidden" name="attribute_ids[]" value="${id}">
                <input type="text" name="attribute_names[]" value="${name}" 
                    placeholder="VD: Kích thước" class="w-1/3 p-2 border rounded">
                <input type="text" name="attribute_values[]" value="${value}" 
                    placeholder="VD: 3cm" class="w-1/3 p-2 border rounded">
                <button type="button" class="text-red-500 px-3 py-1 remove-attribute">x</button>
            </div>`;
            }

            // Thêm thuộc tính mới
            addButton.addEventListener("click", function() {
                container.insertAdjacentHTML("beforeend", createAttributeItem());
                toggleRemoveButtons();
            });

            // Xóa thuộc tính
            container.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-attribute")) {
                    e.target.parentElement.remove();
                    toggleRemoveButtons();
                }
            });

            // Ẩn/Xóa nút "Xóa" nếu chỉ còn một thuộc tính
            function toggleRemoveButtons() {
                const removeButtons = container.querySelectorAll(".remove-attribute");
                removeButtons.forEach((btn) => {
                    btn.style.display = removeButtons.length > 1 ? "inline-block" : "none";
                });
            }

            toggleRemoveButtons();
        });
    </script>

    <script>
        function previewImages(event) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            for (let file of event.target.files) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let imgDiv = document.createElement('div');
                    imgDiv.classList.add('relative', 'border', 'p-1', 'rounded-lg');
                    imgDiv.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded">
                `;
                    preview.appendChild(imgDiv);
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage(imageId) {
            document.getElementById(`image-${imageId}`).remove();
            // Xóa input chứa ID ảnh cũ
            let input = document.querySelector(`input[name="old_images[]"][value="${imageId}"]`);
            if (input) {
                input.remove();
            }
        }
    </script>
@endpush
