<!DOCTYPE html>
<html lang="en" x-data="{ 
    sidebarOpen: localStorage.getItem('sidebarState') === null ? true : localStorage.getItem('sidebarState') === 'true',
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarState', this.sidebarOpen);
    }
}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFlow | Premium Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.02em; }
        [x-cloak] { display: none !important; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .sidebar-gradient { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); }
        .active-link { background: rgba(59, 130, 246, 0.1); color: white; border-right: 4px solid #3b82f6; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased">

    <div class="flex min-h-screen relative">
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'" 
               class="sidebar-gradient text-slate-400 transition-all duration-500 ease-in-out flex flex-col fixed inset-y-0 z-50 shadow-2xl">
            
            <button @click="toggleSidebar()" 
                    class="absolute -right-3 top-1/2 -translate-y-1/2 h-7 w-7 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-xl border-2 border-white hover:bg-blue-700 transition-all z-[60]">
                <svg :class="!sidebarOpen && 'rotate-180'" class="w-4 h-4 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="p-6 flex items-center gap-3 border-b border-slate-800/60 overflow-hidden whitespace-nowrap bg-slate-900/50">
                <div class="h-11 w-11 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex-shrink-0 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>

                <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-300" class="flex flex-col leading-tight">
                    <span class="text-lg font-black text-white tracking-tight uppercase italic">
                        YOU<span class="text-indigo-400">CODE</span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] -mt-0.5">
                        Debrief System
                    </span>
                </div>
            </div>

            <nav class="flex-1 px-3 mt-6 space-y-8 overflow-y-auto overflow-x-hidden">
                <div>
                    <p x-show="sidebarOpen" x-cloak class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Overview</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.dashboard') ? 'active-link text-white' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span x-show="sidebarOpen" x-cloak class="font-bold text-sm whitespace-nowrap">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.users.*') ? 'active-link text-white' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span x-show="sidebarOpen" x-cloak class="font-bold text-sm whitespace-nowrap">Users</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p x-show="sidebarOpen" x-cloak class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Academic</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.classrooms.*') ? 'active-link text-white' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span x-show="sidebarOpen" x-cloak class="font-bold text-sm whitespace-nowrap">Classrooms</span>
                        </a>

                        <a href="{{ route('admin.sprints.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.sprints.*') ? 'active-link text-white' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span x-show="sidebarOpen" x-cloak class="font-bold text-sm whitespace-nowrap">Sprints</span>
                        </a>

                        <a href="{{ route('admin.competences.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.competences.*') ? 'active-link text-white' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-show="sidebarOpen" x-cloak class="font-bold text-sm whitespace-nowrap">Competences</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-slate-800/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center gap-4 px-4 py-3 text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span x-show="sidebarOpen" x-cloak class="text-sm font-bold whitespace-nowrap">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <main :class="sidebarOpen ? 'ml-72' : 'ml-20'" 
              class="flex-1 transition-all duration-500 min-h-screen flex flex-col">
            
            <header class="h-20 glass sticky top-0 z-40 px-8 flex items-center justify-between border-b border-slate-200/50">
                <div class="flex items-center gap-4">
                    <span class="bg-blue-600/10 text-blue-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-600/20">Admin Panel</span>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-slate-900 leading-none">{{ auth()->user()->firstName ?? 'Super' }} {{ auth()->user()->lastName ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest mt-1">Access: {{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                    <div class="h-12 w-12 bg-slate-900 rounded-2xl border-4 border-white shadow-xl overflow-hidden group cursor-pointer active:scale-95 transition-all">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->firstName }}&background=0f172a&color=fff" alt="User">
                    </div>
                </div>
            </header>

            <div class="p-10 bg-[#f8fafc] flex-grow">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>