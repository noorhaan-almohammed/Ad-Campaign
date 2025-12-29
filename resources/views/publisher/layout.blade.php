<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publisher Dashboard</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-white p-5 flex flex-col">
            <h2 class="text-2xl font-bold mb-8">Publisher</h2>

            <nav class="flex flex-col gap-3">

                <a href="{{ route('publisher.dashboard') }}"
                    class="p-2 rounded {{ request()->routeIs('publisher.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('publisher.profile.index') }}"
                    class="p-2 rounded {{ request()->routeIs('publisher.profile.index') ? 'bg-gray-700' : '' }}">
                    profile
                </a>
                <a href="{{ route('publisher.tasks.index') }}"
                    class="p-2 rounded {{ request()->routeIs('publisher.tasks.*') ? 'bg-gray-700' : '' }}">
                    Tasks
                </a>

                <a href="{{ route('publisher.campaigns.index') }}"
                    class="p-2 rounded {{ request()->routeIs('publisher.campaigns.*') ? 'bg-gray-700' : '' }}">
                    Campaigns
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

        {{-- Content --}}
        <main class="flex-1 p-8">
            <div class="bg-white p-4 rounded shadow mb-6">
                <h1 class="text-xl font-semibold">
                    @yield('title', 'Publisher Panel')
                </h1>
            </div>

            @yield('content')
        </main>

    </div>

</body>

</html>
