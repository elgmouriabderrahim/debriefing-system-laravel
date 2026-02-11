<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Debriefing-system')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased font-sans tracking-tight">
    @php
     $user = auth()->user();
     $role = $user->role;
    @endphp

    <div class="flex min-h-screen relative">
        <aside id="mainSidebar" 
               class="w-60 bg-gradient-to-b from-[#0f172a] to-[#1e293b] text-slate-400 transition-all duration-500 ease-in-out flex flex-col fixed inset-y-0 z-50 shadow-2xl">
            
            <button id="sidebarToggle"
                    class="absolute -right-3 top-1/2 -translate-y-1/2 h-7 w-7 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-xl border-2 border-white hover:bg-blue-700 transition-all z-[60]">
                <svg id="toggleIcon" class="w-4 h-4 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="p-6 flex items-center gap-3 border-b border-slate-800/60 overflow-hidden whitespace-nowrap bg-slate-900/50">
                <div class="h-11 w-11 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex-shrink-0 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" />
                    </svg>
                </div>

                <div class="sidebar-text flex flex-col leading-tight transition-all duration-300">
                    <span class="text-lg font-black text-white tracking-tight uppercase italic">
                        YOU<span class="text-indigo-400">CODE</span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] -mt-0.5">
                        Debrief System
                    </span>
                </div>
            </div>

            <nav class="flex-1 px-3 mt-6 space-y-8 overflow-y-auto overflow-x-hidden custom-scrollbar">
            @if($role === "admin")
                <div>
                    <p class="sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Overview</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span class="sidebar-text font-bold text-sm whitespace-nowrap">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.users.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span class="sidebar-text font-bold text-sm whitespace-nowrap">Users</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Academic</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.classrooms.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span class="sidebar-text font-bold text-sm whitespace-nowrap">Classrooms</span>
                        </a>

                        <a href="{{ route('admin.sprints.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.sprints.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span class="sidebar-text font-bold text-sm whitespace-nowrap">Sprints</span>
                        </a>

                        <a href="{{ route('admin.competences.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('admin.competences.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="sidebar-text font-bold text-sm whitespace-nowrap">Competences</span>
                        </a>
                    </div>
                </div>
            @elseif($role === "instructor")
                <p class="sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Overview</p>
                <div class="space-y-1">
                    <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('instructor.dashboard') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span class="sidebar-text font-bold text-sm whitespace-nowrap">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('instructor.classrooms.index') }}" 
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('instructor.classrooms.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="sidebar-text font-bold text-sm whitespace-nowrap">Classrooms</span>
                    </a>

                    <a href="{{ route('instructor.briefs.index') }}" 
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('instructor.briefs.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="sidebar-text font-bold text-sm whitespace-nowrap">Project Briefs</span>
                    </a>
                </div>
            @elseif($role === "learner")
                <p class="sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Overview</p>
                <div class="space-y-1">
                    <a href="{{ route('learner.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('learner.dashboard') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span class="sidebar-text font-bold text-sm whitespace-nowrap">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('learner.briefs.index') }}" 
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('learner.briefs.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="sidebar-text font-bold text-sm whitespace-nowrap">My Briefs</span>
                    </a>

                    <a href="{{ route('learner.debriefings.index') }}" 
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('learner.debriefings.*') ? 'bg-blue-500/10 text-white border-r-4 border-blue-500' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span class="sidebar-text font-bold text-sm whitespace-nowrap">Debriefings</span>
                    </a>
                </div>
            @endif
            </nav>

            <div class="p-4 border-t border-slate-800/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center gap-4 px-4 py-3 text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="sidebar-text text-sm font-bold whitespace-nowrap">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <main id="mainContent" class="ml-60 flex-1 transition-all duration-500 min-h-screen flex flex-col">
            
            <header class="h-16 bg-white/80 backdrop-blur-xl sticky top-0 z-[100] px-8 flex items-center justify-between border-b border-slate-200/50">
                <div class="flex items-center gap-4">
                    @if($role === "admin")
                        <span class="bg-blue-600/10 text-yellow-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-600/20">Admin Panel</span>
                    @elseif($role === "instructor")
                        <span class="bg-blue-600/10 text-green-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-600/20">Instructor Panel</span>
                    @else
                        <span class="bg-blue-600/10 text-green-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-600/20">Learner Panel</span>
                    @endif
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-slate-900 leading-none">{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</p>
                        <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest mt-1">Access: {{ $role ?? 'Admin' }}</p>
                    </div>
                    <div class="h-12 w-12 bg-slate-900 rounded-2xl border-4 border-white shadow-xl overflow-hidden group cursor-pointer active:scale-95 transition-all">
                        <img src="https://ui-avatars.com/api/?name={{ $user->first_name }}&background=0f172a&color=fff" alt="User">
                    </div>
                </div>
            </header>

            <div class="p-10 bg-[#f8fafc] flex-grow">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('mainSidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            let isOpen = localStorage.getItem('sidebarState') === null ? true : localStorage.getItem('sidebarState') === 'true';

            const updateSidebar = (state) => {
                if (state) {
                    sidebar.classList.replace('w-20', 'w-60');
                    mainContent.classList.replace('ml-20', 'ml-60');
                    toggleIcon.classList.remove('rotate-180');
                    sidebarTexts.forEach(el => el.classList.remove('hidden'));
                } else {
                    sidebar.classList.replace('w-60', 'w-20');
                    mainContent.classList.replace('ml-60', 'ml-20');
                    toggleIcon.classList.add('rotate-180');
                    sidebarTexts.forEach(el => el.classList.add('hidden'));
                }
            };

            updateSidebar(isOpen);

            toggleBtn.addEventListener('click', () => {
                isOpen = !isOpen;
                localStorage.setItem('sidebarState', isOpen);
                updateSidebar(isOpen);
            });
        });
    </script>
</body>
</html>