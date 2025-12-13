<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-lg border-r border-gray-200 p-6 flex flex-col">

            <h2 class="text-2xl font-bold text-gray-900 mb-10 tracking-wide">
                Admin Panel
            </h2>

            <nav class="flex flex-col gap-2">

                <a href="{{ route('admin.dashboard') }}"
                    class="px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                    📊 Dashboard
                </a>

                <a href="{{ route('admin.campaigns.index') }}"
                    class="px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.campaigns.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                    📢 Campaigns
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                    👥 Users
                </a>
                <a href="{{ route('admin.withdraw.index') }}"
                    class="px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.withdraw.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                    🏦 Withdraw Requests
                </a>

                <a href="{{ route('admin.invoices.index') }}"
                    class="px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.invoices.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                    💳 Invoices
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="px-3 py-2 rounded-lg transition
                        {{ request()->routeIs('admin.settings.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                    ⚙️ Settings
                </a>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="mt-8 p-2 bg-red-600 text-white rounded">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </nav>

        </aside>

        {{-- Main content --}}
        <main class="flex-1 p-8">

            {{-- Header --}}
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h1 class="text-xl font-semibold text-gray-900">
                    @yield('title', 'Admin Dashboard')
                </h1>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg shadow">
                    ✗ {{ session('error') }}
                </div>
            @endif

            {{-- Page content --}}
            @yield('content')

        </main>
    </div>

</body>

</html>
