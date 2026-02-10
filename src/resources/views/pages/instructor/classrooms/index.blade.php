@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Classroom Management</h1>
            <p class="text-slate-500 font-medium">Overview of all your assigned academic groups.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest">
                {{ $classrooms->count() }} Total Groups
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($classrooms as $class)
        <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:shadow-slate-200/50 transition-all group">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="h-16 w-16 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-lg group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 mb-1">{{ $class->name }}</h3>
                        <div class="flex items-center gap-4 text-sm font-bold text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                {{ $class->learners_count }} Learners
                            </span>
                            <span class="h-1 w-1 bg-slate-300 rounded-full"></span>
                            <span>Promo: {{ $class->promotion_year ?? 'Not Set' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('instructor.classrooms.show', $class->id) }}" 
                       class="px-6 py-3 bg-green-50 text-green-900 font-black text-xs uppercase tracking-widest rounded-xl hover:bg-green-600 hover:text-white transition-all">
                        Manage Group
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
            <p class="text-slate-400 font-bold text-lg">No classrooms found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection