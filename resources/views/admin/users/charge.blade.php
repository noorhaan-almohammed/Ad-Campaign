@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Edit User</h1>

    <div class="bg-white p-8 rounded-xl shadow max-w-xl">
        <form action="{{ route('admin.users.charge', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class=" mb-2 font-medium">Name</label>
                <lable class=" border-gray-300 rounded-lg p-3">
                    {{ ucfirst($user->name) }}</lable>
            </div>
            <div>
                <label class=" mb-2 font-medium">Email</label>
                <lable class=" border-gray-300 rounded-lg p-3">
                    {{ $user->email }}</lable>
            </div>
            <div>
                <label class=" mb-2 font-medium">Role</label>
                <lable class=" border-gray-300 rounded-lg p-3">
                    {{ ucfirst($role->name) }}</lable>
            </div>
            <div class="flex justify-between items-center gap-2">
                <label class="font-medium">Old Balance</label>
                  <lable class=" border-gray-300 rounded-lg p-3">
                    {{ $user->wallet->balance }}</lable>
                $
            </div>
            <div class="flex justify-between items-center gap-2">
                <label class="font-medium">Balance</label>
                <input type="number" name="amount" value="{{ old('amount') }}"
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200 text-blue-900"
                    placeholder="enter balance you want to add">
                $
            </div>
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <button class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Update Balance User
            </button>
        </form>
    </div>
@endsection
