@extends('layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('checked')
    <x-component-navbar active="category" />
@endsection
@section('content')
    <div class="max-w-7xl mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex items-center mb-3 justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('categories.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Danh sách danh mục
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ $category->category_name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <a href="{{ route('categories.index') }}"
                class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Về trước</a>
        </div>

        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

        <h2 class="text-2xl font-extrabold dark:text-white">Danh mục: {{ $category->category_name }}</h2>
        <form action="{{ route('categories.show', $category->slug) }}" method="GET"
            class="flex flex-wrap justify-end items-center gap-2 my-4">
            @csrf
            <input type="text" name="category_name" placeholder="Tên danh mục" value="{{ request('category_name') }}"
                class="border rounded p-2 text-sm" />
            <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Tìm</button>
            <a href="{{ route('categories.show', $category->slug) }}"
                class="bg-gray-400 text-white px-3 py-2 rounded hover:bg-gray-500 text-xs">Xóa lọc</a>
        </form>
        @if ($sub_categories->isEmpty())
            <p class="mt-2">Không có danh mục con nào</p>
        @else
            <table class="w-full border-collapse bg-white shadow-md rounded-md text-xs mt-4">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-2">STT</th>
                        <th class="p-2">Tên danh mục</th>
                        <th class="p-2">Slug</th>
                        <th class="p-2">Mô tả</th>
                        <th class="p-2">Vị trí</th>
                        <th class="p-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sub_categories as $key => $sub_category)
                        <tr class="border-t">
                            <td class="p-2">{{ $key + 1 }}</td>
                            <td class="p-2">
                                <a href="{{ route('categories.show', $sub_category->slug) }}"
                                    class="font-medium dark:text-blue-500 hover:underline">{{ $sub_category->category_name }}</a>
                            </td>
                            <td class="p-2">{{ $sub_category->slug }}</td>
                            <td class="p-2">{{ $sub_category->description }}</td>
                            <td class="p-2">{{ $sub_category->position }}</td>
                            <td class="flex gap-1">
                                <a href="{{ route('categories.edit', $sub_category->slug) }}">
                                    <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" />
                                    </svg>
                                </a>
                                <form action="{{ route('categories.destroy', $sub_category->slug) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button>
                                        <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
