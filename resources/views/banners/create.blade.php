@extends('layouts.main')

@section('title', 'Thêm mới banner')

@section('navbar')
    <x-component-navbar active="banner" />
@endsection

@section('content')
<div class="mx-auto bg-white p-6 rounded-lg shadow-lg text-sm">
    <div class="flex items-center mb-3 justify-between">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('banners.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Danh sách banner
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
        <a href="{{ route('banners.index') }}"
            class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Về trước</a>
    </div>
    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
    <h2 class="text-2xl font-semibold text-center mb-6 text-primary">
        Thêm Mới Banner
    </h2>

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        {{-- Ảnh banner --}}
        <div class="mb-4">
            <label for="image_url" class="block text-sm text-gray-600">Ảnh Banner <span class="text-red-500">*</span></label>
            <input type="file" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" id="image_url" name="image_url" accept="image/*" required>
            @error('image_url')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alt Text --}}
        <div class="mb-4">
            <label for="alt_text" class="block text-sm text-gray-600">Alt Text</label>
            <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" id="alt_text" name="alt_text" placeholder="Mô tả ngắn gọn cho hình ảnh" value="{{ old('alt_text') }}">
            @error('alt_text')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Link --}}
        <div class="mb-4">
            <label for="link" class="block text-sm text-gray-600">Link (nếu có)</label>
            <input type="url" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" id="link" name="link" placeholder="https://..." value="{{ old('link') }}">
            @error('link')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Vị trí --}}
        <div class="mb-4">
            <label for="position" class="block text-sm text-gray-600">Vị trí hiển thị</label>
            <input type="number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" id="position" name="position" min="0" value="{{ old('position', 0) }}">
            @error('position')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Trạng thái --}}
        <div class="mb-4 flex items-center">
            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
            <label for="status" class="ml-2 text-sm text-gray-600">Kích hoạt banner</label>
            @error('status')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nút hành động --}}
        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('banners.index') }}" class="px-4 py-2 text-lg font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-200">
                <i class="bi bi-arrow-left"></i> Hủy
            </a>
            <button type="submit" class="px-4 py-2 text-lg font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                <i class="bi bi-plus-circle"></i> Thêm Mới
            </button>
        </div>
    </form>
</div>
@endsection
