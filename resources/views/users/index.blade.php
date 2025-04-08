@extends('layouts.main')
@section('title', 'Danh sách khách hàng')
@section('navbar')
    <x-component-navbar active="user" />
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
                                khách hàng</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="flex flex-wrap justify-between items-center gap-4 p-4 bg-white mt-4">
            <!-- Bulk Actions -->
            <div class="flex gap-2">
                <form id="bulk-status-form" action="{{ route('users.toggleOn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_ids" id="bulk-status-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-xs"
                        data-target="bulk-status-input">
                        Kích hoạt tài khoản
                    </button>
                </form>
                <form id="bulk-status-off-form" action="{{ route('users.toggleOff') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_ids" id="bulk-status-off-input">
                    <input type="hidden" name="fields" value="status">
                    <button type="button"
                        class="bulk-action-btn bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 text-xs"
                        data-target="bulk-status-off-input">
                        Đáng đấu tạm ngưng
                    </button>
                </form>
            </div>

            <!-- Filters and Actions -->
            <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                @csrf

                <div>
                    <label for="record_number" class="sr-only">Số bản ghi</label>
                    <select id="record_number" name="record_number"
                        class="border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" {{ old('record_number', $numperpage) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ old('record_number', $numperpage) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ old('record_number', $numperpage) == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ old('record_number', $numperpage) == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>

                <div>
                    <label for="email" class="sr-only">Tìm kiếm</label>
                    <input type="text" name="email" placeholder="Tìm kiếm email..."
                        value="{{ old('email', request('email')) }}"
                        class="border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-3 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">Tìm</button>
                <a href="{{ route('users.index') }}"
                    class="bg-gray-400 text-white px-3 py-2 rounded-md shadow-sm hover:bg-gray-500 transition">Xóa lọc</a>
               
            </form>
        </div>

        <table class="w-full border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2"><input type="checkbox" id="selectAll" class="accent-blue-500 hover:cursor-pointer">
                    </th>
                    <th class="p-1">Avatar</th>
                    <th class="p-1">Tên khách hàng</th>
                    <th class="p-1">Email</th>
                    <th class="p-1">Xác thực mail</th>
                    <th class="p-1">Thông tin chung</th>
                    <th class="p-1">Đã mua</th>
                    <th class="p-1">Trạng thái</th>
                    <th class="p-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                        <td class="p-2 text-left">
                            <input type="checkbox" name="user_ids[]" value="{{ $item->id }}"
                                class="accent-blue-500 users-checkbox">
                        </td>
                        <td class="p-1 max-w-[300px]">
                            <img src="{{ asset('storage/' . $item->avatar) }}" alt="Avatar"
                                class="w-8 h-8 rounded-full object-cover border border-gray-300">
                        </td>
                        <td class="p-1 max-w-[300px] font-medium">
                            {{ $item->name }}
                        </td>
                        <td class="p-1 max-w-[300px]">
                            {{ $item->email }}
                        </td>
                        <td class="p-1">
                            @if ($item->email_verified_at == null)
                                <p class="text-red-600">Chưa xác thực</p>
                            @else
                                <p class="text-red-600">{{$item->email_verified_at}}</p>
                            @endif
                        </td>
                        <td class="p-1">
                            <p>Ngày sinh: {{ $item->dob ?? 'Chưa có' }}</p>
                            <p>Số điện thoại: {{ $item->phone ?? 'Chưa có' }}</p>
                            <p>Giới tính: {{ $item->gender ?? 'Chưa có' }}</p>
                            <p class="line-clamp-2">{{ $item->address ?? 'Chưa có' }}</p>
                        </td>
                        <td class="p-1 max-w-[500px]">
                            <p class="text-amber-600">
                                {{$item->orders_count ?? 0}} đơn hàng
                            </p>
                        </td>
                        <td class="p-1 text-center">
                            <form action="{{ route('users.toggleStatus', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" class="sr-only peer"
                                        {{ $item->status ? 'checked' : '' }} onchange="this.form.submit()">

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
                                        {{ $item->status ? 'Đang hoạt động' : 'Ngưng hoạt động' }}
                                    </span>
                                </label>
                            </form>
                        </td>
                        <td class="p-1 ">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('users.edit', $item->id) }}" title="Chỉnh sửa"
                                    class="flex justify-center items-center">
                                    <svg class="w-6 h-6 text-yellow-600 hover:text-yellow-500 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phần phân trang -->
        <div class="mt-1">
            {{ $users->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const categoryCheckBoxs = document.querySelectorAll(".users-checkbox");

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
                        alert("Vui lòng chọn ít nhất một người dùng.");
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
