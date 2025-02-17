<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ParentCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Lọc theo từ khóa tìm kiếm
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('product_code', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục con
        if ($request->has('sub_category_id') && !empty($request->sub_category_id)) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        // Lọc theo thương hiệu
        if ($request->has('brand_id') && !empty($request->brand_id)) {
            $query->where('brand_id', $request->brand_id);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Lọc theo giá
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);
        $subCategories = SubCategory::all();
        $brands = Brand::all();

        return view('admin.products', compact('products', 'subCategories', 'brands'));
    }

    public function add()
    {
        $subCategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.productadd', compact('subCategories', 'brands'));
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string|unique:products,product_code|max:50',
            'name' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|url',
            'slug' => 'required|string|unique:products,slug|max:255',
            'price' => 'required|numeric|min:0',
            'position' => 'nullable|integer|min:1',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'number_purchases' => 'nullable|integer|min:0',
            'made_in' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'brand_id' => 'required|integer|exists:brands,id',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
        ]);

        // Tạo sản phẩm mới
        Product::create($request->all());

        return redirect()->route('admin.products.add')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function edit(Product $product)
    {
        $subCategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.productedit', compact('product', 'subCategories', 'brands'));
    }


    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'stock' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'thumbnail_url' => 'nullable|url',
        ]);

        $product->update($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được xóa!');
    }
}
