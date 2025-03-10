<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:product-create|product-list|product-edit|product-delete'], ['only' => ['index']]);
        $this->middleware(['permission:product-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:product-edit'], ['only' => ['edit', 'update', 'toggleStatus', 'show']]);
        $this->middleware(['permission:product-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 5;
        $products = Product::query()
            ->when($request->product_name, function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->product_name . '%');
            })
            ->with('productReviews')
            ->withAvg('productReviews', 'rating')
            ->orderBy('created_at', 'DESC')
            ->paginate($numperpage);

        $notifications = [];
        foreach ($products as $product) {
            if ($product->quantity_in_stock < 10) {
                $notifications["quantity_in_tock"][$product->id] = "Số lượng sản phẩm " . $product->product_name . " hiện tại còn " . $product->quantity_in_stock . " đã tới ngưỡng cảnh báo 10 với trạng thái tồn kho thấp.";
            }
        }
        return view('products.index', compact('products', 'numperpage', 'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_name'  => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'promotion_price' => 'nullable|numeric|min:0',
            'quantity_in_stock' => 'required|numeric|min:0',
            'category'       => 'required',
            'best_selling' => 'required|boolean',
            'featured' => 'required|boolean',
            'attribute_names' => 'required|array',
            'attribute_values' => 'required|array',
            'description'    => 'nullable|string',
            'status'         => 'required|boolean',
            'images'         => 'required|array|max:5',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->after(function ($validator) use ($request) {
            if ($request->filled('promotion_price') && $request->promotion_price >= $request->price) {
                $validator->errors()->add('promotion_price', 'Giá khuyến mãi phải nhỏ hơn giá gốc.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::create([
            'product_name' => $request->product_name,
            'slug' => Str::slug($request->product_name),
            'description' => $request->description,
            'price' => $request->price,
            'promotion_price' => $request->promotion_price,
            'quantity_in_stock' => $request->quantity_in_stock,
            'best_selling' => $request->best_selling,
            'featured' => $request->featured,
            'status' => $request->status,
            'category_id' => $request->category
        ]);

        dd($product);

        foreach ($request->attribute_names as $index => $attribute_name) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_name' => $attribute_name,
                'attribute_value' => $request->attribute_values[$index]
            ]);
        }

        foreach ($request->images as $index => $image) {
            $path = $image->store('products', 'public');
            if ($request->is_primary == $index) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'is_primary' => 1,
                    'alt_text' => $path,
                ]);
            }
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $path,
                'alt_text' => $path,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Thêm mới sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $images = ProductImage::where('product_id', $product->id)->get();
        $avgRating = ProductReview::avg('rating');
        $productReviews = ProductReview::where('product_id', $product->id)
            ->get();
        $notification = [];
        if ($product->quantity_in_stock < 10) {
            $notification["quantity_in_tock"] = "Số lượng sản phẩm " . $product->product_name . " hiện tại còn " . $product->quantity_in_stock . " đã tới ngưỡng cảnh báo 10 với trạng thái tồn kho thấp.";
        }
        return view('products.show', compact('product', 'images', 'avgRating', 'productReviews', 'notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['attributes', 'images'])->find($id);
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name'   => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'category'       => 'required',
            'attribute_name' => 'nullable|array',
            'attribute_value' => 'nullable|array',
            'quantity_in_stock' => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'status'         => 'required|boolean',
            'images'         => 'nullable|array|max:5',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($id);
        $product->update([
            'product_name' => $request->product_name,
            'slug' => Str::slug($request->product_name),
            'description' => $request->description,
            'quantity_in_stock' => $request->quantity_in_stock,
            'price' => $request->price,
            'status' => $request->status,
            'category_id' => $request->category
        ]);

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return back()->with('success', 'Đã xóa sản phẩm thành công!');
    }

    public function toggleStatus($id)
    {
        $product = Product::find($id);
        $product->status = !$product->status;
        $product->save();
        return back()->with('success', 'Trạng thái sản phẩm đã được cập nhật!');
    }

    public function toggleFeatured($id)
    {
        $product = Product::find($id);
        $product->featured = !$product->featured;
        $product->save();
        return back()->with('success', 'Sản phẩm nổi bật đã được cập nhật!');
    }

    public function toggleBestSelling($id)
    {
        $product = Product::find($id);
        $product->best_selling = !$product->best_selling;
        $product->save();
        return back()->with('success', 'Sản phẩm bán chạy đã được cập nhật!');
    }

    public function toggleOn(Request $request)
    {
        $productIds = explode(',', $request->product_ids);

        if (empty($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm.');
        }

        Product::whereIn('id', $productIds)->update([$request->fields => true]);

        return redirect()->back()->with('success', 'Đã cập nhật các sản phẩm đã chọn.');
    }

    public function toggleOff(Request $request)
    {
        // dd($request->all());
        $productIds = explode(',', $request->product_ids);

        if (empty($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm.');
        }

        Product::whereIn('id', $productIds)->update([$request->fields => false]);

        return redirect()->back()->with('success', 'Đã cập nhật các sản phẩm đã chọn.');
    }
}
