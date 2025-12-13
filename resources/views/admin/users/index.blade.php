@extends('admin.layouts.app')

@section('title','Users')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">Users Management</h1>

{{-- Table Container --}}
<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left border-b">
                <th class="p-3 text-sm font-semibold text-gray-600">ID</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Name</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Email</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Balance</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Role</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-gray-800">{{ $user->id }}</td>
                    <td class="p-3 text-gray-800">{{ $user->name }}</td>
                    <td class="p-3 text-gray-800">{{ $user->email }}</td>
                    <td class="p-3 text-gray-800">{{ $user->wallet->balance ?? 0 }}$</td>

                    <td class="p-3">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                            {{ $user->roles->pluck('name')->first() }}
                        </span>
                    </td>

                    <td class="p-3">
                        @if(($user->status ?? 'active') === 'active')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">Suspended</span>
                        @endif
                    </td>

                    <td class="p-3 flex gap-3">

                        {{-- Edit --}}
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            Edit
                        </a>
                         {{-- Recharge  --}}
                        <a href="{{ route('admin.users.edit.balance', $user) }}"
                           class="text-green-600 hover:text-green-800 font-medium">
                            Recharge Balance
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800 font-medium">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-5 text-center text-gray-500">
                        No users found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-5">
        {{ $users->links('pagination::tailwind') }}
    </div>

</div>

@endsection
