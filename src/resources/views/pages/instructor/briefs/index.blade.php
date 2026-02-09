@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Project Briefs</h1>
            <p class="text-slate-500 font-medium">Manage and assign learning scenarios to your sprints.</p>
        </div>
        <a href="{{ route('instructor.briefs.create') }}" 
   class="inline-flex items-center gap-3 bg-slate-900 hover:bg-emerald-600 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-xl shadow-slate-200 group hover:-translate-y-1">
    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" 
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
    </svg>
    
    <span>Create New Brief</span>
</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($briefs as $brief)
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 hover:shadow-xl transition-all group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 h-24 w-24 bg-indigo-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

            <div class="flex justify-between items-start mb-6 relative">
                <span class="px-4 py-1.5 {{ $brief->type === 'individual' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} rounded-full text-[10px] font-black uppercase tracking-widest border border-current/10">
                    {{ $brief->type }}
                </span>
                <span class="text-slate-400 text-[11px] font-bold">
                    {{ \Carbon\Carbon::parse($brief->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($brief->end_date)->format('M d, Y') }}
                </span>
            </div>

            <h3 class="text-2xl font-black text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $brief->title }}</h3>
            <p class="text-slate-500 text-sm line-clamp-2 mb-6 font-medium leading-relaxed">{{ $brief->content }}</p>

            <div class="flex items-center gap-8 mb-8">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Active Sprint</p>
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 bg-indigo-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-bold text-slate-700">{{ $brief->sprint->name ?? 'Unassigned' }}</span>
                    </div>
                </div>
                <div class="border-l border-slate-100 pl-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Deliverables</p>
                    <span class="text-sm font-bold text-slate-700">{{ $brief->livrables_count }} Total</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <a href="{{ route('instructor.briefs.show', $brief->id) }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-2">
                    View Submissions
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('instructor.briefs.edit', $brief->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
            <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-slate-400 font-bold text-lg">No briefs created yet.</p>
            <p class="text-slate-400 text-sm">Click the button above to start your first project.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection