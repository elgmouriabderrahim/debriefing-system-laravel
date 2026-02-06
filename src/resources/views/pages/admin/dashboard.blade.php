@extends('layouts.admin')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">
                System <span class="text-indigo-600">Insights</span>
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Real-time status of the YOUCODE debriefing ecosystem.</p>
        </div>
        <div class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-2xl border border-slate-100 shadow-sm">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-600"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Node: Production-01</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
        <div class="group bg-white p-7 rounded-[2.5rem] border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 h-24 w-24 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-6 relative z-10">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-indigo-600 text-[10px] font-black bg-indigo-50 px-2 py-1 rounded-lg border border-indigo-100">COMMUNITY</span>
            </div>
            <h4 class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mb-1">Total Identity</h4>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $userCount }}</h2>
            <div class="mt-4 flex gap-2">
                <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">{{ $learnerCount }} LRN / {{ $instructorCount }} STF</span>
            </div>
        </div>

        <div class="group bg-white p-7 rounded-[2.5rem] border border-slate-100 hover:shadow-2xl hover:shadow-violet-500/10 transition-all duration-500 relative overflow-hidden">
            <div class="p-3 bg-violet-50 text-violet-600 rounded-xl w-fit mb-6 group-hover:bg-violet-600 group-hover:text-white transition-all duration-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h4 class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mb-1">Active Clusters</h4>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $classroomCount }}</h2>
            <p class="text-[10px] text-violet-500 mt-2 font-black uppercase tracking-tighter italic">Managed Deployments</p>
        </div>

        <div class="group bg-slate-900 p-7 rounded-[2.5rem] shadow-2xl shadow-slate-900/20 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 h-32 w-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="p-3 bg-white/10 text-white rounded-xl w-fit mb-6 group-hover:bg-indigo-500 transition-all duration-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" /></svg>
            </div>
            <h4 class="text-slate-500 font-bold uppercase text-[10px] tracking-[0.2em] mb-1">Active Briefings</h4>
            <h2 class="text-4xl font-black text-white tracking-tight">{{ $briefCount }}</h2>
            <div class="mt-4 h-1 w-full bg-white/10 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full w-2/3 group-hover:w-full transition-all duration-1000 ease-out"></div>
            </div>
        </div>

        <div class="group bg-white p-7 rounded-[2.5rem] border border-slate-100 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 relative overflow-hidden">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl w-fit mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h4 class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mb-1">Competence Mesh</h4>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $competenceCount }}</h2>
            <p class="text-[10px] text-emerald-500 mt-2 font-black uppercase tracking-tighter italic">Coverage Verified</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 bg-white rounded-[3rem] border border-slate-100 overflow-hidden shadow-sm">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-white/50 backdrop-blur-sm">
                <h3 class="text-sm font-black text-slate-900 tracking-tight uppercase italic">
                    Recent <span class="text-indigo-600">Onboarding</span>
                </h3>
                <a href="{{ route('admin.users.index') }}" class="text-slate-400 hover:text-indigo-600 font-black text-[9px] uppercase tracking-[0.3em] transition-colors">Audit All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[9px] uppercase font-black tracking-[0.2em] border-b border-slate-50">
                            <th class="px-10 py-5">Identity Hash</th>
                            <th class="px-10 py-5">Access Level</th>
                            <th class="px-10 py-5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentUsers as $user)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-[10px] font-black uppercase group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                                        {{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $user->firstName }} {{ $user->lastName }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $user->role === 'admin' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-indigo-50 text-indigo-600 border border-indigo-100' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    <button class="p-2 bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 rounded-lg shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-center mb-8 relative z-10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Latest Briefings</h3>
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                </div>
                <div class="space-y-6 relative z-10">
                    @foreach($recentBriefs as $brief)
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="h-10 w-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-xs font-black text-slate-800 truncate group-hover:text-indigo-600 transition-colors">{{ $brief->title }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-0.5 tracking-tighter">Instructor_ID: {{ $brief->instructor->firstName ?? 'System' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-indigo-950 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden group">
                <div class="absolute -bottom-12 -right-12 h-40 w-40 bg-indigo-500/20 rounded-full blur-3xl group-hover:bg-indigo-500/30 transition-all duration-700"></div>
                
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-2 italic">Workspace Control</p>
                <h3 class="text-2xl font-black mb-4 tracking-tighter uppercase italic">Cluster <span class="text-indigo-400">Hub</span></h3>
                <p class="text-[11px] text-slate-400 leading-relaxed mb-8 font-bold uppercase tracking-wide">Coordinate progress across all {{ $classroomCount }} active deployments and monitor milestones.</p>
                
                <a href="{{ route('admin.classrooms.index') }}" class="flex items-center justify-center gap-3 w-full py-4 bg-indigo-600 text-white text-center rounded-2xl font-black shadow-xl hover:bg-white hover:text-slate-900 transition-all active:scale-95 text-[10px] uppercase tracking-[0.2em]">
                    Access Clusters
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection