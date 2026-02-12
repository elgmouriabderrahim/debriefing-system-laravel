@extends('layouts.main')
@section('title','Debriefings-system | Briefs')
@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-12">

    <div class="flex items-center justify-between bg-white px-8 py-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="h-10 w-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight italic uppercase">My <span class="text-emerald-600">Briefs</span></h1>
        </div>
        <div class="text-right">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active: {{ $briefs->count() }}</span>
        </div>
    </div>

    <div class="space-y-8">
        @forelse($briefs->groupBy('sprint.name') as $sprintName => $sprintBriefs)
            <div class="space-y-3">
                <div class="flex items-center gap-3 px-2">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $sprintName ?? 'Sprint' }}</span>
                    <div class="h-[1px] flex-1 bg-slate-100"></div>
                </div>

                <div class="grid grid-cols-1 gap-2">
                    @foreach($sprintBriefs as $brief)
                        @php
                            $hasSubmitted = $brief->livrables()->where('learner_id', auth()->id())->exists();
                        @endphp
                        
                        <div class="group bg-white rounded-2xl border border-slate-100 p-4 hover:border-emerald-500/30 hover:bg-slate-50/30 transition-all duration-200">
                            <div class="flex items-center gap-6">
                                
                                <div class="flex-shrink-0">
                                    <div class="h-3 w-3 rounded-full {{ $hasSubmitted ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-slate-200' }}"></div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors truncate">
                                            {{ $brief->title }}
                                        </h3>
                                        <span class="text-[10px] font-medium text-slate-400">
                                            Due {{ \Carbon\Carbon::parse($brief->end_date)->format('d M') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="hidden md:flex items-center gap-1.5">
                                    @foreach($brief->competences->take(2) as $comp)
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md uppercase tracking-tighter">
                                            {{ $comp->code }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('learner.briefs.show', $brief->id) }}" 
                                       class="px-4 py-2 rounded-xl text-slate-400 hover:text-slate-900 font-bold text-[11px] uppercase transition-all">
                                        Details
                                    </a>

                                    <a href="{{ route('learner.briefs.submit', $brief->id) }}" 
                                       class="inline-flex items-center gap-2 {{ $hasSubmitted ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-900 text-white' }} px-5 py-2 rounded-xl font-bold text-[11px] uppercase tracking-wide transition-all hover:-translate-y-0.5 active:scale-95 shadow-sm">
                                        {{ $hasSubmitted ? 'Update' : 'Submit' }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">No briefs found</p>
            </div>
        @endforelse
    </div>
</div>
@endsection