<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertiser Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans overflow-hidden">

    <!-- Top Navbar -->
    <nav class="bg-green-950 shadow-md px-6 py-4 flex justify-between items-center fixed w-full top-0 z-50">
        <h1 class="text-2xl font-semibold text-white">Advertiser Panel</h1>

        <div class="flex items-center space-x-4">
            <span class="text-gray-100 font-medium text-xl">{{ auth()->user()->name }}</span>
        </div>
    </nav>

    <div class="flex min-h-screen mt-16">

        <!-- Sidebar -->
        <aside class="w-64 bg-green-950 shadow-lg h-screen py-6 hidden md:block">
            <ul class="space-y-4 text-lg">
                <li>
                    <a href="{{ route('advertiser.dashboard') }}"
   class="relative block w-full py-2 px-4 font-medium transition
   {{ request()->routeIs('advertiser.dashboard')
        ? 'bg-green-100 text-green-950 font-semibold before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-green-600'
        : 'text-gray-100 hover:bg-green-50 hover:text-green-950'
   }}">
    Dashboard
</a>

                </li>
                <li>
                 
                    <a href="{{  route('advertiser.profile.index') }}"
   class="relative block w-full py-2 px-4 font-medium transition
   {{ request()->routeIs('advertiser.profile*')
        ? 'bg-green-100 text-green-950 font-semibold before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-green-600'
        : 'text-gray-100 hover:bg-green-50 hover:text-green-950'
   }}">
    Profile
</a>

                </li>
                <li>
                    <a href="{{ route('advertiser.campaigns.index') }}"
   class="relative block w-full py-2 px-4 font-medium transition
   {{ request()->routeIs('advertiser.campaigns*')
        ? 'bg-green-100 text-green-950 font-semibold before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-green-600'
        : 'text-gray-100 hover:bg-green-50 hover:text-green-950'
   }}">
    Campaigns
</a>

                </li>
                <li>
                   <a href="{{ route('advertiser.tasks.index') }}"
   class="relative block w-full py-2 px-4 font-medium transition
   {{ request()->routeIs('advertiser.tasks*')
        ? 'bg-green-100 text-green-950 font-semibold before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-green-600'
        : 'text-gray-100 hover:bg-green-50 hover:text-green-950'
   }}">
    Tasks
</a>

                </li>
                <li>
                   <a href="{{ route('advertiser.invoices.index') }}"
   class="relative block w-full py-2 px-4 font-medium transition
   {{ request()->routeIs('advertiser.invoices*')
        ? 'bg-green-100 text-green-950 font-semibold before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-green-600'
        : 'text-gray-100 hover:bg-green-50 hover:text-green-950'
   }}">
    Invoices
</a>

                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left mt-6 py-2 px-4 hover:bg-red-500 hover:text-gray-200 bg-red-600 font-medium text-white transition">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 bg-green-50 max-h-screen overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>

</html>
