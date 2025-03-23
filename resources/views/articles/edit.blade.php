@extends('layouts.main')
@section('title', 'Chỉnh sửa bài viết')
@section('navbar')
    <x-component-navbar active="article" />
@endsection
@section('content')
    <div class="mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex items-center mb-3 justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('articles.index') }}"
                            class="inline-flex items-center font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Danh sách bài viết
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Chỉnh sửa</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="bg-white p-6">
            <h2 class="text-xl font-bold mb-4">Chỉnh Sửa Bài Viết</h2>
            <form action="{{ route('articles.update', $article->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-4 gap-2">
                    <div class="col-span-3">
                        <div class="mb-6">
                            <label for="title-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiêu đề</label>
                            <input type="text" id="title-input" name="title" value="{{ $article->title }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('title')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả
                                ngắn</label>
                            <textarea id="message" rows="4" name="short_description"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Viết mô tả ngắn...">{{ $article->short_description }}</textarea>
                            @error('short_description')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="editor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bài
                                viết</label>
                            <textarea id="editor" rows="20" name="content"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Hãy viết bài tại đây...">{{ $article->content }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
                            Cập nhật bài viết
                        </button>

                        <button type="reset" class="text-white bg-gray-600 hover:bg-gray-500 rounded p-2 transition">
                            Xóa hết
                        </button>
                    </div>
                    <div class="px-2">
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Tải
                                hình đại diện</label>
                            <!-- Hiển thị ảnh hiện tại -->
                            @if ($article->thumbnail_url)
                                <div class="mb-2">
                                    <img id="thumbnail_preview" src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                        alt="Current Thumbnail"
                                        class="w-32 h-32 object-cover rounded-md border border-gray-300 shadow-sm">
                                </div>
                            @endif
                            <!-- Input file -->
                            <input name="thumbnail"
                                class="p-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 
       dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help" id="file_input" type="file" accept="image/*">
                            @error('thumbnail')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="mb-6">
                            @error('articleCategories')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chọn
                                danh mục</label>
                            <select id="countries" name="articleCategories"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Chọn danh mục</option>
                                @foreach ($articleCategoires as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $article->article_category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="mb-6">
                            <h3 class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái</h3>
                            @error('status')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                            <div class="flex items-center mb-4">
                                <input id="default-radio-1" type="radio" value="1" name="status"
                                    {{ $article->status == 1 ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-1"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hiển thị</label>
                            </div>
                            <div class="flex items-center">
                                <input id="default-radio-2" type="radio" value="0" name="status"
                                    {{ $article->status == 0 ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-2"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tạm ẩn</label>
                            </div>
                        </div>
                        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
                            <h2 class="text-sm font-bold mb-4">Tìm kiếm Và Chọn Sản phẩm</h2>
                            @error('selected_product')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                            <!-- Ô tìm kiếm sản phẩm -->
                            <input type="text" id="searchInput" placeholder="Nhập tên sản phẩm..."
                                class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 mb-4"
                                onkeyup="searchProducts()">

                            <!-- Danh sách sản phẩm -->
                            <ul id="productList" class="space-y-2">
                                @foreach ($products as $item)
                                    <li class="p-3 border rounded-lg bg-gray-100 flex items-center">
                                        <input type="radio" class="product-checkbox" id="{{ $item->id }}"
                                            name="selected_product" value="{{ $item->id }}"
                                            {{ $article->product_id == $item->id ? 'checked' : '' }}
                                            onclick="updateSelectedProducts()">
                                        <label for="{{ $item->id }}"
                                            class="ml-2">{{ $item->product_name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                            <input type="hidden" id="selectedProducts" name="selected_product"
                                value="{{ $article->product_id }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('header')
@endpush
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor

                .create(document.querySelector("#editor"), {
                    toolbar: [
                        'undo', 'redo', '|', 'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'bulletedList', 'numberedList', '|',
                        'alignment', 'outdent', 'indent', '|',
                        'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'imageUpload', 'imageResize', 'imageStyle:full', 'imageStyle:side', '|',
                        'horizontalLine', 'specialCharacters', '|',
                        'removeFormat', 'sourceEditing'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            }
                        ]
                    },
                    ckfinder: {
                        uploadUrl: '{{ route('upload.articleImage') }}',
                        options: {
                            resourceType: 'Images'
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    <!-- Hiển thị ảnh xem trước khi chọn file mới -->
    <script>
        document.getElementById('file_input').addEventListener('change', function(event) {
            let preview = document.getElementById('thumbnail_preview');
            let file = event.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        function searchProducts() {
            let query = document.getElementById("searchInput").value.toLowerCase();
            let products = document.querySelectorAll("#productList li");

            products.forEach(product => {
                product.style.display = product.innerText.toLowerCase().includes(query) ? "block" : "none";
            });
        }

        function updateSelectedProducts() {
            let selectedProduct = document.querySelector(".product-checkbox:checked");

            if (selectedProduct) {
                document.getElementById("selectedProducts").value = selectedProduct.value;
            } else {
                document.getElementById("selectedProducts").value = "";
            }
        }
    </script>
@endpush
