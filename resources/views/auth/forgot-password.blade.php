<x-guest-layout>
    <div class="w-full min-h-screen bg-[#0f0a2c] flex flex-col items-center justify-center">
        <div class="bg-indigo-900/50 p-20 rounded-xl shadow-sm shadow-indigo-300/10">
            <h2 class="text-2xl font-bold text-white mb-4">Reset Password</h2>

            <p class="text-gray-300 mb-6">
                Forgot your password? No problem. Enter your email below and we will send you a link to reset it.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-100" />
                    <x-text-input id="email" class="block mt-1 w-full text-gray-900" type="email" name="email"
                        :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-purple-400 hover:underline">
                        Back to login
                    </a>

                    <x-primary-button class="bg-purple-600 hover:bg-purple-700">
                        {{ __('Send Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
