<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
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
            ->with('productReviews', 'images')
            ->withAvg('productReviews', 'rating')
            ->orderBy('created_at', 'DESC')
            ->paginate($numperpage);


        $notifications = [];
        foreach ($products as $product) {
            if ($product->quantity_in_stock < 10) {
                $notifications["quantity_in_stock"][$product->id] = "Số lượng sản phẩm " . $product->product_name . " hiện tại còn " . $product->quantity_in_stock . " đã tới ngưỡng cảnh báo 10 với trạng thái tồn kho thấp.";
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
        $validator = Validator::make(
            $request->all(),
            [
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
                'images'         => 'required|array',
                'images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [
                'product_name.required' => 'Tên sản phẩm không được bỏ trống.',
                'product_name.string' => 'Tên sản phẩm phải là một chuỗi ký tự.',
                'product_name.max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',

                'price.required' => 'Giá sản phẩm không được bỏ trống.',
                'price.numeric' => 'Giá sản phẩm phải là một số.',
                'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',

                'promotion_price.numeric' => 'Giá khuyến mãi phải là một số.',
                'promotion_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',

                'quantity_in_stock.required' => 'Số lượng trong kho không được bỏ trống.',
                'quantity_in_stock.numeric' => 'Số lượng trong kho phải là một số.',
                'quantity_in_stock.min' => 'Số lượng trong kho không được nhỏ hơn 0.',

                'category.required' => 'Danh mục sản phẩm không được bỏ trống.',

                'best_selling.required' => 'Trường sản phẩm bán chạy không được bỏ trống.',
                'best_selling.boolean' => 'Giá trị của sản phẩm bán chạy phải là đúng hoặc sai.',

                'featured.required' => 'Trường sản phẩm nổi bật không được bỏ trống.',
                'featured.boolean' => 'Giá trị của sản phẩm nổi bật phải là đúng hoặc sai.',

                'attribute_names.required' => 'Tên thuộc tính không được bỏ trống.',
                'attribute_names.array' => 'Tên thuộc tính phải là một mảng.',

                'attribute_values.required' => 'Giá trị thuộc tính không được bỏ trống.',
                'attribute_values.array' => 'Giá trị thuộc tính phải là một mảng.',

                'description.string' => 'Mô tả sản phẩm phải là một chuỗi ký tự.',

                'status.required' => 'Trạng thái sản phẩm không được bỏ trống.',
                'status.boolean' => 'Trạng thái sản phẩm phải là đúng hoặc sai.',

                'images.required' => 'Hình ảnh sản phẩm không được bỏ trống.',
                'images.array' => 'Hình ảnh sản phẩm phải là một mảng.',
                'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
                'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif hoặc svg.',
                'images.*.max' => 'Hình ảnh không được vượt quá 2048KB.'
            ]
        )->after(function ($validator) use ($request) {
            if ($request->filled('promotion_price') && $request->promotion_price >= $request->price) {
                $validator->errors()->add('promotion_price', 'Giá khuyến mãi phải nhỏ hơn giá gốc.');
            }
        });

        // dd('adsadads');
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
            'promotion_price' => 'required|numeric|min:0',
            'category'       => 'required',
            'attribute_name' => 'nullable|array',
            'attribute_value' => 'nullable|array',
            'quantity_in_stock' => 'required|numeric|min:0',
            'best_selling'  => 'required|numeric',
            'featured'      => 'required|numeric',
            'description'    => 'nullable|string',
            'status'         => 'required|boolean',
            'images'         => 'nullable|array',
            'old_images' => 'array',
            'is_primary' => 'nullable|exists:product_images,id',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'numeric' => ':attribute phải là số.',
            'min' => ':attribute phải có giá trị tối thiểu là :min.',
            'boolean' => ':attribute phải là đúng hoặc sai.',
            'image' => ':attribute phải là một hình ảnh.',
            'mimes' => ':attribute phải có định dạng: jpeg, png, jpg, gif, svg.',
            'max' => ':attribute không được lớn hơn :max KB.',
            'exists' => ':attribute không hợp lệ.',
        ])->after(function ($validator) use ($request) {
            if ($request->filled('promotion_price') && $request->promotion_price >= $request->price) {
                $validator->errors()->add('promotion_price', 'Giá khuyến mãi phải nhỏ hơn giá gốc.');
            }
        });

        $product = Product::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'slug' => Str::slug($request->product_name),
            'price' => $request->price,
            'promotion_price' => $request->promotion_price,
            'description' => $request->description,
            'quantity_in_stock' => $request->quantity_in_stock,
            'best_selling' => $request->best_selling,
            'featured' => $request->featured,
            'status' => $request->status,
            'category_id' => $request->category
        ]);

        // Lấy danh sách ID thuộc tính cũ từ DB
        $existingAttributeIds = $product->attributes->pluck('id')->toArray();

        // Dữ liệu từ form
        $attributeIds = $request->attribute_ids;
        $attributeNames = $request->attribute_names;
        $attributeValues = $request->attribute_values;

        $newAttributeIds = [];

        foreach ($attributeNames as $index => $name) {
            $attributeId = $attributeIds[$index] ?? null;
            $value = $attributeValues[$index] ?? null;

            if ($attributeId) {
                // Cập nhật thuộc tính cũ
                ProductAttribute::where('id', $attributeId)
                    ->where('product_id', $product->id)
                    ->update([
                        'attribute_name' => $name,
                        'attribute_value' => $value,
                    ]);
                $newAttributeIds[] = $attributeId;
            } else {
                // Tạo thuộc tính mới
                $newAttribute = ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_name' => $name,
                    'attribute_value' => $value,
                ]);
                $newAttributeIds[] = $newAttribute->id;
            }
        }

        // Xóa thuộc tính không có trong danh sách mới
        $attributesToDelete = array_diff($existingAttributeIds, $newAttributeIds);
        ProductAttribute::whereIn('id', $attributesToDelete)->delete();

        // Xóa ảnh cũ nếu không giữ lại
        $oldImages = $request->old_images ?? [];
        ProductImage::where('product_id', $product->id)
            ->whereNotIn('id', $oldImages)
            ->each(function ($image) {
                Storage::delete('public/' . $image->image_url);
                $image->delete();
            });

        // Upload ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Cập nhật ảnh chính
        ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
        if ($request->is_primary) {
            ProductImage::where('id', $request->is_primary)->update(['is_primary' => true]);
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        $isOrder = OrderItem::where('product_id', $product->id)->first();

        if ($isOrder) {
            return back()->with('error', 'Không thể xóa sản phẩm do đã có đơn hàng phát sinh!');
        }
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
