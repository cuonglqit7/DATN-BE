@extends('layouts.main')
@section('title', 'Quản lý người dùng')
@section('navbar')
    <x-component-navbar active="user" />
@endsection
@section('content')
    <div class="max-w-7xl mx-auto bg-white p-3 rounded-lg shadow-md text-sm">
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
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách khách
                                hàng</span>
                        </div>
                    </li>
                </ol>
            </nav>
            @can('user-create')
                <a href="{{ route('users.create') }}"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Thêm người dùng</a>
            @endcan

        </div>
        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
        <form action="{{ route('users.index') }}" method="POST" class="flex flex-wrap justify-end items-center gap-2 my-4">
            @csrf
            @method('GET')
            <div>
                <select id="record_number" name="record_number"
                    class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="5" {{ $numperpage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $numperpage == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $numperpage == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ $numperpage == 20 ? 'selected' : '' }}>20</option>
                </select>
            </div>
            <input type="text" name="name" placeholder="Tên người dùng" value="{{ request('name') }}"
                class="border rounded p-2 text-sm" />
            <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-xs">Tìm</button>
            <a href="{{ route('users.index') }}"
                class="bg-gray-400 text-white px-3 py-2 rounded hover:bg-gray-500 text-xs">Xóa lọc</a>
        </form>

        <table class="w-full border-collapse bg-white shadow-lg rounded-lg text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3"><input type="checkbox" id="selectAll" class="accent-blue-500 hover:cursor-pointer">
                    </th>
                    <th class="p-3">Tên người dùng</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if ($user->getRoleNames() === 'user')
                        <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                            <td class="p-3 text-left">
                                <input type="checkbox" name="selected_users[]" value="{{ $user->id }}"
                                    class="accent-blue-500">
                            </td>
                            <td class="p-3">
                                <a href="{{ route('users.show', $user->id) }}"
                                    class="font-semibold text-blue-600 hover:underline">{{ $user->name }}</a>
                            </td>
                            <td class="p-3">
                                {{ $user->email }}
                            </td>
                            <td class="p-3">
                                @can('user-edit')
                                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="status" class="sr-only peer"
                                                {{ $user->status ? 'checked' : '' }} onchange="this.form.submit()">

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
                                                {{ $user->status ? 'Hiển thị' : 'Ẩn' }}
                                            </span>
                                        </label>
                                    </form>
                                @endcan
                            </td>

                            <td class="p-3 flex gap-2 justify-start">
                                @can('user-edit')
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="p-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-white transition-all">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endcan
                                @can('user-delete')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 bg-red-500 hover:bg-red-600 rounded-full text-white transition-all">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            <p>Chức năng hàng loạt:</p>
            <div class="mt-2 flex space-x-2">
                <button class="p-2 bg-green-500 hover:bg-green-600 rounded-full text-white transition-all" title="Bật">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9 16.17 4.83 12a1 1 0 0 0-1.41 1.41l5.25 5.25a1 1 0 0 0 1.41 0l10.25-10.25a1 1 0 1 0-1.41-1.41L9 16.17Z" />
                    </svg>
                </button>
                <button class="p-2 bg-red-500 hover:bg-red-600 rounded-full text-white transition-all" title="Xóa">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Phần phân trang -->
        <div class="mt-4 flex justify-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    {{-- chọn nhiều danh mục --}}
    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_users[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000",
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
            };

            toastr.success("{{ session('success') }}", "Thành công 🎉");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endpush
