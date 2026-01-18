<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CallBot - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Toasts Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
        @if(session('success'))
        <div class="toast bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        @if(session('error'))
        <div class="toast bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <span>{{ session('error') }}</span>
        </div>
        @endif
    </div>

    <div class="flex h-screen">
        
        <!-- Sidebar -->
        <aside class="w-72 sidebar-gradient text-white flex flex-col">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center text-xl">
                        🍕
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">{{ Auth::user()->restaurant->nom ?? 'CallBot' }}</h1>
                        <p class="text-xs text-gray-400">Espace Restaurant</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('restaurant.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('restaurant.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Tableau de bord</span>
                </a>
                <a href="{{ route('restaurant.commandes') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('restaurant.commandes') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">📋</span>
                    <span class="font-medium">Commandes</span>
                </a>
                <a href="{{ route('restaurant.menu') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('restaurant.menu') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">🍽️</span>
                    <span class="font-medium">Mon menu</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-white/10">
                <div class="bg-white/5 rounded-xl p-4 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">Restaurant</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-500/10 text-red-400 px-4 py-2 rounded-xl text-sm hover:bg-red-500/20 transition-colors cursor-pointer">
                        🚪 Déconnexion
                    </button>
                </form>
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