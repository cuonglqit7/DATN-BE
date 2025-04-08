@extends('layouts.main')
@section('title', 'Danh sách danh mục bài viết')
@section('navbar')
    <x-component-navbar active="category" />
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
                                danh
                                mục bài viết</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="flex justify-between align-center ">
            <div class="flex justify-start items-center gap-2">
                <form id="bulk-status-form" action="{{ route('articleCategories.toggleOn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="articleCategory_ids" id="bulk-status-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-xs"
                        data-target="bulk-status-input">
                        Hiển thị
                    </button>
                </form>

                <form id="bulk-status-off-form" action="{{ route('articleCategories.toggleOff') }}" method="POST">
                    @csrf
                    <input type="hidden" name="articleCategory_ids" id="bulk-status-off-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 text-xs"
                        data-target="bulk-status-off-input">
                        Tạm ẩn
                    </button>
                </form>
            </div>

            <form action="{{ route('articleCategories.index') }}" method="POST"
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
                <input type="text" name="name" placeholder="Tìm kiếm" value="{{ old('name', request('name')) }}"
                    class="border rounded p-2 text-sm" />
                <button type="submit"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Tìm</button>
                <a href="{{ route('articleCategories.index') }}"
                    class="bg-gray-400 text-white px-3 py-2 rounded hover:bg-gray-500 text-xs">Xóa lọc</a>
                @can('item-create')
                    <a href="{{ route('articleCategories.create') }}"
                        class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Thêm mới</a>
                @endcan
                <a href="{{ route('articleCategories.create') }}"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Thêm mới</a>
            </form>
        </div>

        <table class="w-full border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2"><input type="checkbox" id="selectAll" class="accent-blue-500 hover:cursor-pointer">
                    </th>
                    <th class="p-1">Tên danh mục</th>
                    <th class="p-1">Slug</th>
                    <th class="p-2 text-center">Số bài viết</th>
                    <th class="p-2 w-96">Mô tả</th>
                    <th class="p-2 text-center">Vị trí</th>
                    <th class="p-2 text-left">Trạng thái</th>
                    <th class="p-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articleCategories as $category)
                    @if ($category->parent_id == null)
                        <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                            <td class="p-2 text-left">
                                <input type="checkbox" name="articleCategory_ids[]" value="{{ $category->id }}"
                                    class="accent-blue-500 articleCategories-checkbox">
                            </td>
                            <td class="p-1">
                                {{ $category->name }}
                            </td>

                            <td class="p-1 text-gray-600">{{ $category->slug }}</td>
                            <td class="p-1 text-center">{{ $category->articles_count ?? 0 }} bài viết</td>
                            <td class="p-1">{{ $category->description ?? 'Không có' }}</td>
                            <td class="p-1 text-center">
                                <form method="POST"
                                    action="{{ route('articleCategories.updatePosition', $category->id) }}">
                                    @csrf
                                    <input type="number" class="w-10 ps-1 border-2 border-solid"
                                        value="{{ $category->position }}" name="position" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="p-1 text-left">
                                <form action="{{ route('articleCategories.toggleStatus', $category->id) }}" method="POST">
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

                            <td class="p-1 flex gap-1 justify-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('articleCategories.edit', $category->id) }}" title="Chỉnh sửa">
                                        <svg class="w-6 h-6 text-yellow-600 hover:text-yellow-500 dark:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('articleCategories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Phần phân trang -->
        <div class="mt-1">
            {{ $articleCategories->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const categoryCheckBoxs = document.querySelectorAll(".articleCategories-checkbox");

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
