@extends('admin.layouts.app')

@section('title','Edit User')

@section('content')
<h1 class="text-3xl font-bold mb-8">Edit User</h1>

<div class="bg-white p-8 rounded-xl shadow max-w-xl">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name',$user->name) }}"
                class="w-full border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email',$user->email) }}"
                class="w-full border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-medium">Role</label>
            <select name="role" class="w-full border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-200">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        @if($user->hasRole($role->name)) selected @endif>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Update User
        </button>
    </form>
</div>
@endsection
