<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AdManager — Advertising Campaign Platform</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-[#0f0f16] text-gray-200 antialiased">

    <!-- Navbar -->
    <header class="w-full py-4 px-6 flex justify-between items-center bg-[#141421]/80 shadow-md fixed z-50">
        <h1 class="text-2xl font-bold text-indigo-400">AdManager</h1>

        <nav class="flex items-center gap-6">
            <a href="#about" class="hover:text-indigo-400 transition">About</a>
            <a href="#pricing" class="hover:text-indigo-400 transition">Pricing</a>
            <a href="#testimonials" class="hover:text-indigo-400 transition">Testimonials</a>

            @auth
                <a href="{{ route('admin.dashboard') }}"
                   class="text-indigo-300 font-semibold hover:text-indigo-400 transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-gray-100 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                    Create Account
                </a>
            @endauth
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section class="min-h-[100vh] flex flex-col md:flex-row items-center justify-between px-8 py-16 bg-gradient-to-l to-[#141421]/50 from-indigo-500/50 ">

        <!-- Text -->
        <div class="max-w-3xl">
            <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                Manage Your Advertising Campaigns with Confidence & Control
            </h2>

            <p class="text-gray-400 mt-4 text-lg">
                A complete platform for advertisers and agencies to plan, launch, track, and optimize campaigns with ease.
            </p>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('register') }}"
                   class="px-8 py-3 bg-indigo-600 text-white rounded-lg text-lg font-semibold hover:bg-indigo-700 transition">
                    Start Now
                </a>
                <a href="#pricing"
                   class="px-8 py-3 border border-indigo-500 text-indigo-300 rounded-lg text-lg font-semibold hover:bg-indigo-700/20 transition">
                    View Pricing
                </a>
            </div>
        </div>

        <!-- Image -->
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="/images/hero.png"
                 alt="AdManager platform dashboard displaying campaign management interface with budget tracking, media upload sections, and analytics charts on a dark theme with indigo accents"
                 class="w-full rounded-xl shadow-2xl border border-indigo-800/20">
        </div>

    </section>

    <!-- ABOUT US -->
    <section id="about" class="py-20 bg-[#141421] px-8">
        <h3 class="text-3xl font-bold text-center text-white mb-10">About Us</h3>

        <div class="max-w-4xl mx-auto text-center text-gray-300 text-lg leading-relaxed">
            AdManager is a modern advertising management platform built to help businesses and agencies streamline
            their marketing operations.
            <br><br>
            We provide smart tools for managing campaigns, budgets, analytics, invoices, and approvals — all in one place.
        </div>
    </section>

    <!-- PRICING PLANS -->
    <section id="pricing" class="py-20 px-8">
        <h3 class="text-3xl font-bold text-center text-white mb-14">Pricing Plans</h3>

        <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">

            <!-- Basic -->
            <div class="p-8 bg-[#1b1b2d] rounded-xl shadow-lg border border-indigo-600/20 hover:border-indigo-400 transition">
                <h4 class="text-2xl font-semibold text-indigo-300 mb-2">Basic</h4>
                <p class="text-gray-400 mb-6">For freelancers & small advertisers</p>
                <p class="text-4xl font-bold text-white mb-6">$19<span class="text-lg text-gray-400">/mo</span></p>

                <ul class="space-y-2 text-gray-300 mb-6">
                    <li>✔ 5 Campaigns</li>
                    <li>✔ Basic Media Upload</li>
                    <li>✔ Email Support</li>
                </ul>

                <a href="{{ route('register') }}"
                   class="w-full block text-center py-2 bg-indigo-600 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Choose Plan
                </a>
            </div>

            <!-- Pro -->
            <div class="p-8 bg-[#241b35] rounded-xl shadow-xl border border-indigo-500 hover:border-indigo-300 transition transform scale-105">
                <h4 class="text-2xl font-semibold text-indigo-300 mb-2">Pro</h4>
                <p class="text-gray-400 mb-6">Perfect for growing businesses</p>
                <p class="text-4xl font-bold text-white mb-6">$49<span class="text-lg text-gray-400">/mo</span></p>

                <ul class="space-y-2 text-gray-300 mb-6">
                    <li>✔ Unlimited Campaigns</li>
                    <li>✔ Advanced Analytics</li>
                    <li>✔ Priority Support</li>
                </ul>

                <a href="{{ route('register') }}"
                   class="w-full block text-center py-2 bg-indigo-600 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Choose Plan
                </a>
            </div>

            <!-- Enterprise -->
            <div class="p-8 bg-[#1b1b2d] rounded-xl shadow-lg border border-indigo-600/20 hover:border-indigo-400 transition">
                <h4 class="text-2xl font-semibold text-indigo-300 mb-2">Enterprise</h4>
                <p class="text-gray-400 mb-6">For agencies & large teams</p>
                <p class="text-4xl font-bold text-white mb-6">Custom</p>

                <ul class="space-y-2 text-gray-300 mb-6">
                    <li>✔ Dedicated Manager</li>
                    <li>✔ API Integration</li>
                    <li>✔ Tailored Solutions</li>
                </ul>

                <a href="#contact"
                   class="w-full block text-center py-2 bg-indigo-600 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Contact Us
                </a>
            </div>

        </div>
    </section>


    <!-- Features -->
    <section class="py-16 px-6 bg-[#141421]">
        <h3 class="text-3xl font-bold text-center text-white mb-12">Why Choose AdManager?</h3>

        <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">

            <div class="p-6 bg-[#1b1b2d] rounded-xl shadow-md hover:shadow-xl transition border border-indigo-700/20">
                <h4 class="text-xl font-semibold text-indigo-300 mb-2">Campaign Management</h4>
                <p class="text-gray-400">
                    Create campaigns, assign budgets, upload media, schedule timelines, and monitor progress easily.
                </p>
            </div>

            <div class="p-6 bg-[#1b1b2d] rounded-xl shadow-md hover:shadow-xl transition border border-indigo-700/20">
                <h4 class="text-xl font-semibold text-indigo-300 mb-2">Invoices & Payments</h4>
                <p class="text-gray-400">
                    Generate invoices, track their status, and record payments through a streamlined billing system.
                </p>
            </div>

            <div class="p-6 bg-[#1b1b2d] rounded-xl shadow-md hover:shadow-xl transition border border-indigo-700/20">
                <h4 class="text-xl font-semibold text-indigo-300 mb-2">Admin Dashboard</h4>
                <p class="text-gray-400">
                    Manage users, approve campaigns, review media, and oversee all financial and operational activities.
                </p>
            </div>

        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section id="testimonials" class="py-20 px-8">
        <h3 class="text-3xl font-bold text-center text-white mb-14">What Clients Say</h3>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">

            <div class="p-6 bg-[#1b1b2d] rounded-xl border border-indigo-700/20 shadow-md">
                <p class="text-gray-300 mb-4">
                    “AdManager transformed the way we run campaigns. Easy, fast, and powerful.”
                </p>
                <h4 class="text-indigo-300 font-semibold">— Sarah Wilson</h4>
                <p class="text-gray-500 text-sm">Marketing Manager</p>
            </div>

            <div class="p-6 bg-[#1b1b2d] rounded-xl border border-indigo-700/20 shadow-md">
                <p class="text-gray-300 mb-4">
                    “The analytics and reporting tools are simply amazing. Highly recommended!”
                </p>
                <h4 class="text-indigo-300 font-semibold">— Michael Carter</h4>
                <p class="text-gray-500 text-sm">Agency Owner</p>
            </div>

            <div class="p-6 bg-[#1b1b2d] rounded-xl border border-indigo-700/20 shadow-md">
                <p class="text-gray-300 mb-4">
                    “We saved a ton of time managing multiple campaigns across clients.”
                </p>
                <h4 class="text-indigo-300 font-semibold">— Emily Johnson</h4>
                <p class="text-gray-500 text-sm">Digital Marketer</p>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-6 text-center text-gray-500 bg-[#141421] mt-20 border-t-2 border-indigo-200/20">
        © {{ date('Y') }} AdManager — All rights reserved.
    </footer>

</body>

</html>
