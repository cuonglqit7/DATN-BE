@extends('layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('navbar')
    <x-component-navbar active="category" />
@endsection
@section('content')
    <div class="h-full mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
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
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách danh
                                mục</span>
                        </div>
                    </li>
                </ol>
            </nav>
            @can('category-create')
                <a href="{{ route('categories.create') }}"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Thêm sản danh mục mới</a>
            @endcan

        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="flex justify-between">
            <div>
                <p>Chức năng hàng loạt:</p>
                <div class="mt-2">
                    <button class="p-2 bg-red-500 hover:bg-red-600 rounded-full text-white transition-all">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <form action="{{ route('categories.index') }}" method="POST"
                class="flex flex-wrap justify-end items-center gap-2 my-4">
                @csrf
                @method('GET')
                <div>
                    <select id="record_number" name="record_number"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" {{ $numperpage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $numperpage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $numperpage == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $numperpage == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>
                <input type="text" name="name" placeholder="Tên quyền" value="{{ request('name') }}"
                    class="border rounded p-2 text-sm" />
                <button type="submit"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Tìm</button>
                <a href="{{ route('categories.index') }}"
                    class="bg-gray-400 text-white px-3 py-2 rounded hover:bg-gray-500 text-xs">Xóa lọc</a>
            </form>
        </div>

        <table class="w-full border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-1"><input type="checkbox" id="selectAll" class="accent-blue-500 hover:cursor-pointer">
                    </th>
                    <th class="p-2">Tên danh mục</th>
                    <th class="p-2">Slug</th>
                    <th class="p-2">SL Sản phẩm</th>
                    <th class="p-2">Mô tả</th>
                    <th class="p-2">Vị trí</th>
                    <th class="p-2">Trạng thái</th>
                    <th class="p-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    @if ($category->parent_id == null)
                        <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                            <td class="p-1 text-left">
                                <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"
                                    class="accent-blue-500">
                            </td>
                            <td class="p-1">
                                @can('category-list')
                                    <a href="{{ route('categories.show', $category->slug) }}"
                                        title="{{ $category->category_name }}"
                                        class="font-semibold text-blue-600 hover:underline">{{ $category->category_name }}</a>
                                @else
                                    {{ $category->category_name }}
                                @endcan
                            </td>

                            <td class="p-1 text-gray-600">{{ $category->slug }}</td>
                            <td class="p-1 text-left">{{ $category->products_count ?? 0 }} sản phẩm</td>
                            <td class="p-1">{{ $category->description }}</td>
                            <td class="p-1 text-left">{{ $category->position }}</td>

                            @can('category-edit')
                                <td class="p-1 text-left">
                                    <form action="{{ route('categories.toggleStatus', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="status" class="sr-only peer"
                                                {{ $category->status ? 'checked' : '' }} onchange="this.form.submit()">

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
                                                {{ $category->status ? 'Hiển thị' : 'Ẩn' }}
                                            </span>
                                        </label>
                                    </form>
                                </td>
                            @endcan

                            <td class="p-1 flex gap-2 justify-start">
                                @can('category-edit')
                                    <a href="{{ route('categories.edit', $category->slug) }}"
                                        class="p-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-white transition-all">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- Phần phân trang -->
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    {{-- chọn nhiều danh mục --}}
    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_categories[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
    <x-toastr />
@endpush
