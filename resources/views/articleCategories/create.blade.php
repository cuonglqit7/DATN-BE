@extends('layouts.main')
@section('title', 'Thêm mới danh mục bài viết')
@section('navbar')
    <x-component-navbar active="category" />
@endsection
@section('content')
    <div class="mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex items-center mb-3 justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('articleCategories.index') }}"
                            class="inline-flex items-center font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Danh sách danh mục bài viết
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Thêm mới</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="bg-white p-6">
            <h2 class="text-xl font-bold mb-4">Thêm Danh Mục Mới</h2>
            <form action="{{ route('articleCategories.store') }}" method="POST">
                @csrf

                <!-- Tên danh mục -->
                <div class="mb-4">
                    <label for="name" class="block font-medium mb-1">Tên danh mục</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vị trí -->
                <div class="mb-4">
                    <label for="position" class="block font-medium mb-1">Vị trí</label>
                    <input type="number" id="position" name="position" value="{{ old('position') }}" min="1"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    @error('position')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div class="mb-4">
                    <label for="description" class="block font-medium mb-1">Mô tả</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                </div>

                <!-- Trạng thái -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Trạng thái</label>
                    <div class="flex items-center gap-4">
                        <!-- Hiển thị -->
                        <label class="flex items-center gap-1">
                            <input type="radio" name="status" value="1"
                                {{ old('status', 1) == '1' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                            <span class="text-sm font-medium">Hiển thị</span>
                        </label>

                        <!-- Ẩn -->
                        <label class="flex items-center gap-1">
                            <input type="radio" name="status" value="0"
                                {{ old('status', 1) == '0' ? 'checked' : '' }} class="h-4 w-4 text-red-600">
                            <span class="text-sm font-medium">Ẩn</span>
                        </label>
                    </div>
                </div>


                <!-- Nút gửi -->
                <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
                    Thêm danh mục
                </button>

                <button type="reset" class="text-white bg-gray-600 hover:bg-gray-500 rounded p-2 transition">
                    Xóa hết
                </button>
            </form>
        </div>

    </div>
@endsection
