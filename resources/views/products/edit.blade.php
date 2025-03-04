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
        <form class="max-w-4xl mx-auto grid grid-cols-2 gap-5" action="{{ route('products.update', $product->id) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-span-2 mt-2">
                <label for="product_name" class="block text-sm font-medium text-gray-700">
                    Tên sản phẩm (tối đa 100 ký tự)
                </label>
                <input type="text" name="product_name" id="product_name" maxlength="100"
                    value="{{ $product->product_name }}"
                    class="mt-1 block w-full bg-gray-100 rounded-md border-gray-400 p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Nhập tên sản phẩm..." required oninput="updateCharCount()">
                <p id="char-count" class="text-xs text-gray-500 mt-1">0/100 ký tự</p>
            </div>
            @error('product_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Giá</label>
                <input type="number" name="price" id="price" min="1" value="{{ $product->price }}"
                    class="mt-1 block w-full bg-gray-100 rounded-md border-gray-400 p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Nhập giá sản phẩm..." required oninput="formatPrice(this)">
                <p id="formatted-price" class="text-xs text-gray-500 mt-1"></p>
            </div>
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Danh mục</label>
                <select name="category" id="category"
                    class="mt-1 block w-full bg-gray-100 rounded-md border-2 border-gray-400 p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="" disabled>Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category->category_name === $category->category_name ? 'selected' : '' }}>
                            {{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- Mô tả -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 p-3 block w-full bg-gray-100 rounded-lg border-2 border-gray-300 bg-blue-20 focus:ring-blue-600 focus:border-blue-300 sm:text-sm"
                    required>{{ $product->description }}</textarea>
            </div>
            @error('desciption')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <div>
                <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
                <div class="flex gap-4 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="status" value="1" {{ $product->status === 1 ? 'checked' : '' }}
                            class="hidden peer">
                        <span
                            class="peer-checked:bg-blue-600 peer-checked:text-white px-4 py-2 rounded-md border border-gray-400 cursor-pointer">
                            ✅ Hiển thị
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status" value="0" {{ $product->status === 0 ? 'checked' : '' }}
                            class="hidden peer">
                        <span
                            class="peer-checked:bg-red-600 peer-checked:text-white px-4 py-2 rounded-md border border-gray-400 cursor-pointer">
                            🚫 Ẩn
                        </span>
                    </label>
                </div>
            </div>
            @error('status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- Nút xác nhận -->
            <div class="col-span-2 flex justify-start">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center">Cập
                    nhật sản phẩm</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        function updateCharCount() {
            let input = document.getElementById('product_name');
            let count = document.getElementById('char-count');
            count.textContent = `${input.value.length}/100 ký tự`;
        }
    </script>
    <script>
        function formatPrice(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
            document.getElementById('formatted-price').textContent =
                value ? `Giá: ${parseInt(value).toLocaleString('vi-VN')} VND` : '';
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('discountSelect');
            const list = document.getElementById('selectedDiscountsList');
            const input = document.getElementById('discountsInput');

            select.addEventListener('change', function() {
                const selectedOption = select.options[select.selectedIndex];
                const discountId = selectedOption.value;
                const discountType = selectedOption.getAttribute('data-type');
                const discountValue = selectedOption.getAttribute('data-value');

                if (discountId && !document.querySelector(`li[data-id="${discountId}"]`)) {
                    const listItem = document.createElement('li');
                    listItem.setAttribute('data-id', discountId);
                    listItem.classList.add('selected-discount', 'flex', 'justify-between', 'bg-gray-200',
                        'p-2', 'rounded', 'mt-2');
                    listItem.innerHTML =
                        `${discountType} - ${discountValue} <button class="text-red-500 remove-discount">Xóa</button>`;

                    list.appendChild(listItem);
                    updateHiddenInput();
                }
            });

            list.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-discount')) {
                    event.target.parentElement.remove();
                    updateHiddenInput();
                }
            });

            function updateHiddenInput() {
                const selectedIds = Array.from(document.querySelectorAll('.selected-discount')).map(item => item
                    .getAttribute('data-id'));
                input.value = selectedIds.join(',');
            }
        });
    </script>

    <script>
        let removedAttributes = [];
        let newAttributes = [];

        function addAttribute() {
            let nameInput = document.getElementById("attribute_name");
            let valueInput = document.getElementById("attribute_value");

            let name = nameInput.value.trim();
            let value = valueInput.value.trim();

            if (name === "" || value === "") {
                alert("Vui lòng nhập đầy đủ thuộc tính và giá trị!");
                return;
            }

            let container = document.getElementById("attribute-list");

            let div = document.createElement("div");
            div.classList.add("flex", "gap-3", "items-center", "attribute-item");


            let inputId = document.createElement("input");
            inputId.type = "hidden";
            inputId.name = "attribute_id[]";
            inputId.value = "new"; // Đánh dấu là thuộc tính mới

            let inputName = document.createElement("input");
            inputName.type = "text";
            inputName.name = "attribute_name[]";
            inputName.value = name;
            inputName.classList.add("mt-1", "block", "w-full", "bg-gray-100", "rounded-md", "border-gray-400", "p-2",
                "shadow-sm", "focus:ring-blue-500", "focus:border-blue-500", "sm:text-sm");
            inputName.oninput = function() {
                markAsUpdated(inputId);
            };

            let inputValue = document.createElement("input");
            inputValue.type = "text";
            inputValue.name = "attribute_value[]";
            inputValue.value = value;
            inputValue.classList.add("mt-1", "block", "w-full", "bg-gray-100", "rounded-md", "border-gray-400", "p-2",
                "shadow-sm", "focus:ring-blue-500", "focus:border-blue-500", "sm:text-sm");
            inputValue.oninput = function() {
                markAsUpdated(inputId);
            };

            let removeBtn = document.createElement("button");
            removeBtn.innerHTML = "Xóa";
            removeBtn.type = "button";
            removeBtn.classList.add("text-red-500", "hover:text-red-700", "text-sm", "font-semibold");
            removeBtn.onclick = function() {
                container.removeChild(div);
            };

            div.appendChild(inputId);
            div.appendChild(inputName);
            div.appendChild(inputValue);
            div.appendChild(removeBtn);
            container.appendChild(div);

            // Đánh dấu là thuộc tính mới
            newAttributes.push({
                name,
                value
            });

            // Reset input fields
            nameInput.value = "";
            valueInput.value = "";
        }

        function markAsUpdated(inputId) {
            if (inputId.value !== "new" && !newAttributes.includes(inputId.value)) {
                inputId.value = "updated";
            }
        }

        function removeAttribute(button, attributeId = null) {
            let container = document.getElementById("attribute-list");
            let attributeDiv = button.parentElement;

            // Nếu thuộc tính có ID từ CSDL, ta lưu ID vào danh sách xóa
            if (attributeId !== null) {
                removedAttributes.push(attributeId);
                document.getElementById("removed_attributes").value = JSON.stringify(removedAttributes);
            }

            // Xóa khỏi giao diện
            container.removeChild(attributeDiv);
        }
    </script>
@endpush
