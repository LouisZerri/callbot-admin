<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CallBot Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar-gradient { background: linear-gradient(180deg, #1e1e2e 0%, #2d2d44 100%); }
        .card-hover { transition: all 0.2s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        
        <!-- Sidebar -->
        <aside class="w-72 sidebar-gradient text-white flex flex-col">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center text-xl">
                        🍕
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">CallBot</h1>
                        <p class="text-xs text-gray-400">Novaris Solutions</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.restaurants.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.restaurants.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">🏪</span>
                    <span class="font-medium">Restaurants</span>
                </a>
                <a href="{{ route('admin.commandes.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.commandes.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">📋</span>
                    <span class="font-medium">Commandes</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="bg-white/5 rounded-xl p-4">
                    <p class="text-xs text-gray-400 mb-1">Statut système</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-sm text-green-400">Opérationnel</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white border-b border-gray-200 px-8 py-6">
                <h2 class="text-2xl font-bold text-gray-800">@yield('title')</h2>
                @hasSection('subtitle')
                <p class="text-gray-500 mt-1">@yield('subtitle')</p>
                @endif
            </header>
            <div class="p-8">
                @yield('content')
            </div>
        </main>

    </div>
</body>
</html>