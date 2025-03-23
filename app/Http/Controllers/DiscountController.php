<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $numperpage = $request->record_number ?? 10;
        $all = Discount::all();
        $discounts = Discount::query()
            ->when($request->name, function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->name . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', 'like', '%' . $request->status . '%');
            })
            ->when($request->start_date, function ($query) use ($request) {
                $query->where('start_date', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->where('end_date', '<=', $request->end_date);
            })
            ->paginate($numperpage);
        $notifications = [];
        foreach ($all as $key => $discount) {
            if ($discount->start_date <= $today && $discount->end_date >= $today && $discount->status == 'inactive') {
                $notifications[$discount->id] = 'Mã ' . $discount->code . ' đang trong thời gian có thể hoạt động nhưng bị tạm ẩn!';
            }
        }
        return view('discounts.index', compact('discounts', 'numperpage', 'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'code' => 'required|string|max:50|unique:discounts',
                'description' => 'nullable|string|max:255',
                'discount_type' => 'required|in:Percentage,Fixed Amount',
                'discount_value' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'numper_usage' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive,upcoming,expired',
            ],
            [
                'code.required' => 'Mã giảm giá không được để trống.',
                'code.max' => 'Mã giảm giá không được vượt quá 50 kí tự.',
                'code.unique' => 'Mã giảm giá đã tồn tại, vui lòng chọn mã khác.',
                'description.max' => 'Mô tả không vượt quá 255 kí tự',
                'discount_type.required' => 'Loại giảm giá không được để trống.',
                'discount_value.required' => 'Giá trị giảm giá không được để trống.',
                'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
                'start_date.required' => 'Ngày bắt đầu không được để trống.',
                'end_date.required' => 'Ngày kết thúc không được để trống.',
                'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
                'numper_usage.required' => 'Số lần sử dụng không được bỏ trống.',
                'numper_usage.min' => 'Số lần sử dụng không được nhỏ hơn 0.',
                'status.required' => 'Trạng thái không hợp lệ.',
            ]
        );

        $today = Carbon::today();
        if ($request->status == 'active') {
            if ($request->start_date > $today) {
                $status = 'upcoming';
            } elseif ($request->start_date <= $today && $request->end_date >= $today) {
                $status = 'active';
            } elseif ($request->end_date < $today) {
                $status = 'expired';
            }
        } else {
            $status = 'inactive';
        }

        Discount::create([
            'code' => $request->code,
            'description' => $request->description ?? null,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'numper_usage' => $request->numper_usage,
            'status' => $status,
        ]);

        return redirect()->route('discounts.index')->with('success', 'Mã khuyến mãi đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $discount = Discount::find($id);
        return view('discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discount = Discount::find($id);

        $request->validate(
            [
                'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
                'description' => 'nullable|string|max:255',
                'discount_type' => 'required|in:Percentage,Fixed Amount',
                'discount_value' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'numper_usage' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive,upcoming,expired',
            ],
            [
                'code.required' => 'Mã giảm giá không được để trống.',
                'code.max' => 'Mã giảm giá không được vượt quá 50 kí tự.',
                'code.unique' => 'Mã giảm giá đã tồn tại, vui lòng chọn mã khác.',
                'description.max' => 'Mô tả không vượt quá 255 kí tự',
                'discount_type.required' => 'Loại giảm giá không được để trống.',
                'discount_value.required' => 'Giá trị giảm giá không được để trống.',
                'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
                'start_date.required' => 'Ngày bắt đầu không được để trống.',
                'end_date.required' => 'Ngày kết thúc không được để trống.',
                'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
                'numper_usage.required' => 'Số lần sử dụng không được bỏ trống.',
                'numper_usage.min' => 'Số lần sử dụng không được nhỏ hơn 0.',
                'status.required' => 'Trạng thái không hợp lệ.',
            ]
        );

        $today = Carbon::today();
        if ($request->status == 'active') {
            if ($request->start_date > $today) {
                $status = 'upcoming';
            } elseif ($request->start_date <= $today && $request->end_date >= $today) {
                $status = 'active';
            } elseif ($request->end_date < $today) {
                $status = 'expired';
            }
        } else {
            $status = 'inactive';
        }

        $discount->code = $request->code;
        $discount->description = $request->description;
        $discount->discount_type = $request->discount_type;
        $discount->discount_value = $request->discount_value;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->numper_usage = $request->numper_usage;
        $discount->status = $status;
        $discount->save();

        return redirect()->route('discounts.index')->with('success', 'Mã khuyến mãi đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus()
    {
        $today = \Carbon\Carbon::today();

        // Cập nhật các mã giảm giá có trạng thái không phải "inactive"
        Discount::where('status', '!=', 'inactive')
            ->where('start_date', '>', $today)
            ->update(['status' => 'upcoming']);

        Discount::where('status', '!=', 'inactive')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->update(['status' => 'active']);

        Discount::where('status', '!=', 'inactive')
            ->where('end_date', '<', $today)
            ->update(['status' => 'expired']);

        return back()->with('success', 'Trạng thái khuyến mãi đã được cập nhật!');
    }


    public function toggleOff(string $id)
    {
        $discount = Discount::find($id);

        if ($discount->status == 'expired') {
            return back()->with('error', 'không cập nhật được do khuyến mãi đã hết hạn!');
        }
        $discount->status = 'inactive';
        $discount->save();

        return back()->with('success', 'Cập nhật mã khuyến mãi thành công!');
    }
    public function toggleOn(string $id)
    {
        $discount = Discount::find($id);

        $today = Carbon::today();
        if ($discount->start_date > $today) {
            $discount->status = 'upcoming';
        } else if ($discount->start_date <= $today && $discount->end_date >= $today) {
            $discount->status = 'active';
        } else if ($discount->end_date < $today) {
            $discount->status = 'expired';
        }
        $discount->save();
        return back()->with('success', 'Đã kích hoạt mã khuyến mã!');
    }

    public function toggleBulkOn(Request $request)
    {
        $ids = explode(',', $request->discount_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một bài viết.');
        }

        $today = Carbon::today(); // Lấy ngày hôm nay

        Discount::whereIn('id', $ids)
            ->where('start_date', '>', $today)
            ->update(['status' => 'upcoming']);

        Discount::whereIn('id', $ids)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->update(['status' => 'active']);

        Discount::whereIn('id', $ids)
            ->where('end_date', '<', $today)
            ->update(['status' => 'expired']);

        return redirect()->back()->with('success', 'Kích hoạt mã khuyến mãi thành công.');
    }

    public function toggleBulkOff(Request $request)
    {
        $ids = explode(',', $request->discount_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một mã khuyến mãi.');
        }

        // Lấy danh sách ID có trạng thái 'expired'
        $expiredIds = Discount::whereIn('id', $ids)
            ->where('status', 'expired')
            ->pluck('id')
            ->toArray();

        // Lọc ra danh sách ID có thể cập nhật
        $validIds = array_diff($ids, $expiredIds);

        if (empty($validIds)) {
            return redirect()->back()->with('error', 'Không thể ẩn vì tất cả mã đã hết hạn.');
        }

        // Cập nhật trạng thái 'inactive' cho các mã hợp lệ
        Discount::whereIn('id', $validIds)->update(['status' => 'inactive']);

        return redirect()->back()->with('success', 'Tạm ẩn mã khuyến mãi thành công.');
    }
}
