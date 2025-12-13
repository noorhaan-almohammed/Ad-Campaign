<x-guest-layout>
    <div class="min-h-screen min-w-screen flex items-center justify-center bg-gray-950 p-6">
        <div class="w-full max-w-md bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-800">

            <!-- Title -->
            <h2 class="text-3xl font-bold text-center text-white mb-6">
                Welcome Back
            </h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-300 mb-1" for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-300 mb-1" for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember me -->
                <div class="flex items-center mb-4">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded bg-gray-800 border-gray-600 text-purple-600 focus:ring-purple-500"
                    >
                    <label for="remember_me" class="ml-2 text-sm text-gray-400">Remember me</label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-purple-400 hover:text-purple-300 transition">
                            Forgot Password?
                        </a>
                    @endif

                    <button
                        type="submit"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition shadow-lg shadow-purple-700/30"
                    >
                        Log in
                    </button>
                </div>

                <!-- Register -->
                <div class="text-center mt-6">
                    <a href="{{ route('register') }}"
                       class="text-sm text-gray-300 hover:text-purple-400 transition font-semibold">
                        Don’t have an account? <span class="text-purple-500">Register</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
