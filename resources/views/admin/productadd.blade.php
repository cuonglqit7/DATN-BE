@extends('layouts.main')

@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="max-w-7xl mx-auto bg-white p-4 rounded-lg shadow-md max-h-[80vh] overflow-y-auto">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Thêm Sản Phẩm</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Mã sản phẩm</label>
                        <input type="text" name="product_code" value="{{ old('product_code') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                            placeholder="Nhập mã sản phẩm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Tên sản phẩm</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                            placeholder="Nhập tên sản phẩm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Ảnh sản phẩm</label>
                        <input type="file" name="thumbnail_url"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Giá</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                            placeholder="Nhập giá">
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Vị trí</label>
                        <input type="number" name="position" value="{{ old('position', 1) }}" min="1"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Số lượng tồn kho</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Nơi sản xuất</label>
                        <input type="text" name="made_in" value="{{ old('made_in') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                            placeholder="Nhập nơi sản xuất">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Trạng thái</label>
                        <select name="status" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Mô tả ngắn</label>
                <textarea name="short_description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Nhập mô tả ngắn">{{ old('short_description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Mô tả chi tiết</label>
                <textarea name="long_description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Nhập mô tả chi tiết">{{ old('long_description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">Thương hiệu</label>
                    <input type="number" name="brand_id" value="{{ old('brand_id') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                        placeholder="Nhập ID thương hiệu">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">Danh mục con</label>
                    <select name="sub_category_id[]" multiple
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @if (isset($subCategories) && count($subCategories) > 0)
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}"
                                    {{ in_array($subCategory->id, old('sub_category_id', [])) ? 'selected' : '' }}>
                                    {{ $subCategory->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>Chưa có danh mục con</option>
                        @endif
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition">
                Thêm Sản Phẩm
            </button>
        </form>
    </div>
@endsection
