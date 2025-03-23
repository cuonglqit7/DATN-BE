@extends('layouts.main')
@section('title', 'Thêm mới khuyến mãi')
@section('navbar')
    <x-component-navbar active="promo" />
@endsection
@section('content')
    <div class="mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
        <div class="flex items-center mb-3 justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('discounts.index') }}"
                            class="inline-flex items-center font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Danh sách khuyến mãi
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
            <h2 class="text-xl font-bold mb-4">Thêm mới mã khuyến mãi</h2>
            <form action="{{ route('discounts.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">

                    <!-- Mã khuyến mãi -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Mã khuyến mãi</label>
                        <input type="text" name="code" id="code" placeholder="Nhập mã code khuyến mãi..."
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('code')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Số lần sử dụng -->
                    <div>
                        <label for="numper_usage" class="block text-sm font-medium text-gray-700">Số lần sử dụng của khách
                            hàng</label>
                        <input type="number" name="numper_usage" id="numper_usage" min="0" value="0"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('numper_usage')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Loại giảm giá -->
                    <div>
                        <label for="discount_type" class="block text-sm font-medium text-gray-700">Loại giảm giá</label>
                        @error('discount_type')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        <select name="discount_type" id="discount_type"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Percentage">Phần trăm</option>
                            <option value="Fixed Amount">Số tiền cố định</option>
                        </select>
                    </div>

                    <!-- Giá trị giảm giá -->
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700">Giá trị giảm</label>
                        <input type="number" step="10" name="discount_value" id="discount_value"
                            placeholder="Nhập giá trị..."
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('discount_value')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex gap-2">
                        <!-- Ngày bắt đầu -->
                        <div class="w-1/2">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt đầu</label>
                            <input type="date" name="start_date" id="start_date"
                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('start_date')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ngày kết thúc -->
                        <div class="w-1/2">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc</label>
                            <input type="date" name="end_date" id="end_date"
                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm 
                                       focus:ring-red-500 focus:border-red-500">

                            @error('end_date')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Trạng thái -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
                        @error('status')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        <select name="status" id="status"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="active">Kích hoạt
                            </option>
                            <option value="inactive">Tạm ẩn
                            </option>
                        </select>
                    </div>

                    <!-- Mô tả -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                        @error('description')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        <textarea name="description" id="description" rows="3" placeholder="Nhập mô tả cho khuyến mãi"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>

                <!-- Nút lưu -->
                <div class="mt-4 flex justify-end gap-2">
                    <button type="reset"
                        class="bg-gray-400 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-500 transition">Reset</button>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">
                        Thêm mới
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
