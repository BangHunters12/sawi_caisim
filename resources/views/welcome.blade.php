<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sawi Caisim Monitoring</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">GreenMonitor</span>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-600 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-full hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/40">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/50 to-white -z-10"></div>
        <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-gradient-to-br from-emerald-200/20 to-teal-200/20 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-emerald-100/50 text-emerald-600 text-sm font-semibold mb-6 border border-emerald-100">
                Smart IoT Agriculture
            </span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                Monitor Your <span class="text-emerald-600">Sawi Caisim</span> <br>
                With Precision
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10">
                Real-time monitoring of soil moisture, water levels, and nutrient concentration. Automate your farm with our advanced IoT solution.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-600/30 hover:shadow-emerald-600/40 hover:-translate-y-1">
                    Start Monitoring Now
                </a>
                <a href="#features" class="px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all hover:-translate-y-1">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Everything You Need</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Complete control over your hydroponic or soil-based system with our comprehensive feature set.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-emerald-50/50 transition-colors border border-gray-100 hover:border-emerald-100 group">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">📊</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Real-time Analytics</h3>
                    <p class="text-gray-500">Track temperature, humidity, and soil moisture in real-time with beautiful interactive charts.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-emerald-50/50 transition-colors border border-gray-100 hover:border-emerald-100 group">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🤖</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Smart Automation</h3>
                    <p class="text-gray-500">Automatically control water and nutrient pumps based on configurable sensor thresholds.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-emerald-50/50 transition-colors border border-gray-100 hover:border-emerald-100 group">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">📱</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Remote Control</h3>
                    <p class="text-gray-500">Take manual control of your farm's systems from anywhere in the world via our dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold">GreenMonitor</span>
                </div>
                <div class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Sawi Caisim Monitoring. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
