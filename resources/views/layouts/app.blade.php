<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sawi Caisim Monitoring</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-72 bg-gradient-to-b from-emerald-900 to-emerald-950 text-white hidden md:flex flex-col shadow-xl z-20 transition-all duration-300 ease-in-out">
            <div class="p-6">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="sidebar-text overflow-hidden transition-all duration-300">
                        <span class="text-xl font-bold tracking-wide block whitespace-nowrap">GreenMonitor</span>
                        <span class="text-xs text-emerald-400 uppercase tracking-wider font-semibold whitespace-nowrap">IoT System</span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto overflow-x-hidden">
                <p class="sidebar-text px-4 text-xs font-semibold text-emerald-500 uppercase tracking-wider mb-2 mt-2 transition-all duration-300 whitespace-nowrap">Menu</p>
                
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-600/20 text-emerald-100 shadow-inner border border-emerald-500/20' : 'text-emerald-300/80 hover:bg-emerald-800/50 hover:text-white hover:translate-x-1' }}">
                    <div class="{{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-emerald-500 group-hover:text-emerald-300' }} transition-colors min-w-[20px]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <span class="sidebar-text font-medium transition-all duration-300 whitespace-nowrap">Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                        <div class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)] transition-all duration-300"></div>
                    @endif
                </a>

                <a href="{{ route('analytics') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('analytics') ? 'bg-emerald-600/20 text-emerald-100 shadow-inner border border-emerald-500/20' : 'text-emerald-300/80 hover:bg-emerald-800/50 hover:text-white hover:translate-x-1' }}">
                    <div class="{{ request()->routeIs('analytics') ? 'text-emerald-400' : 'text-emerald-500 group-hover:text-emerald-300' }} transition-colors min-w-[20px]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="sidebar-text font-medium transition-all duration-300 whitespace-nowrap">Analytics</span>
                    @if(request()->routeIs('analytics'))
                        <div class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)] transition-all duration-300"></div>
                    @endif
                </a>

                <p class="sidebar-text px-4 text-xs font-semibold text-emerald-500 uppercase tracking-wider mb-2 mt-6 transition-all duration-300 whitespace-nowrap">Configuration</p>

                <a href="{{ route('control.index') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('control.*') ? 'bg-emerald-600/20 text-emerald-100 shadow-inner border border-emerald-500/20' : 'text-emerald-300/80 hover:bg-emerald-800/50 hover:text-white hover:translate-x-1' }}">
                    <div class="{{ request()->routeIs('control.*') ? 'text-emerald-400' : 'text-emerald-500 group-hover:text-emerald-300' }} transition-colors min-w-[20px]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <span class="sidebar-text font-medium transition-all duration-300 whitespace-nowrap">Manual Control</span>
                    @if(request()->routeIs('control.*'))
                        <div class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)] transition-all duration-300"></div>
                    @endif
                </a>

                <a href="{{ route('settings.index') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('settings.*') ? 'bg-emerald-600/20 text-emerald-100 shadow-inner border border-emerald-500/20' : 'text-emerald-300/80 hover:bg-emerald-800/50 hover:text-white hover:translate-x-1' }}">
                    <div class="{{ request()->routeIs('settings.*') ? 'text-emerald-400' : 'text-emerald-500 group-hover:text-emerald-300' }} transition-colors min-w-[20px]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <span class="sidebar-text font-medium transition-all duration-300 whitespace-nowrap">Settings</span>
                    @if(request()->routeIs('settings.*'))
                        <div class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)] transition-all duration-300"></div>
                    @endif
                </a>
            </nav>

            <div class="p-4 border-t border-emerald-800/50 bg-emerald-900/30">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white font-bold shadow-md border-2 border-emerald-700">
                        {{ substr(Auth::user()->name ?? 'UA', 0, 2) }}
                    </div>
                    <div class="sidebar-text overflow-hidden transition-all duration-300">
                        <p class="text-sm font-semibold text-white whitespace-nowrap">{{ Auth::user()->name ?? 'User Admin' }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-xs text-emerald-400 hover:text-emerald-300 whitespace-nowrap transition-colors">Edit Profile</a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="sidebar-text ml-auto">
                        @csrf
                        <button type="submit" class="text-emerald-400 hover:text-red-400 transition-colors" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="p-2 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="text-emerald-600"></span> Sawi Caisim Monitoring
                        </h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium flex items-center gap-1">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            System Online
                        </span>
                        @yield('header-actions')
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                    </div>
                </div>
            </header>

            <div class="p-8 space-y-8">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const texts = document.querySelectorAll('.sidebar-text');
            
            if (sidebar.classList.contains('w-72')) {
                // Collapse
                sidebar.classList.remove('w-72');
                sidebar.classList.add('w-20');
                texts.forEach(el => el.classList.add('opacity-0', 'w-0'));
            } else {
                // Expand
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-72');
                texts.forEach(el => el.classList.remove('opacity-0', 'w-0'));
            }
        }
    </script>
</body>
</html>
