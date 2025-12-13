<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-950 p-6">
        <div class="w-full max-w-md bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-800">

            <!-- Title -->
            <h2 class="text-3xl font-bold text-center text-white mb-6">
                Create Account
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-300 mb-1" for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white
                               focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-300 mb-1" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white
                               focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-300 mb-1" for="password">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white
                               focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-gray-300 mb-1" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white
                               focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('password_confirmation')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account type -->
                <div class="mb-4">
                    <label for="role" class="block text-gray-300 mb-1">Account Type</label>
                    <select id="role" name="role" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white
                               focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="advertiser">Advertiser</option>
                        <option value="publisher">Publisher</option>
                    </select>
                    @error('role')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}"
                       class="text-sm text-purple-400 hover:text-purple-300 transition">
                        Already registered?
                    </a>

                    <button type="submit"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition
                               shadow-lg shadow-purple-700/30">
                        Register
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
