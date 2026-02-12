@extends('layouts.main')
@section('title','Debriefings-system | Briefs')
@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-12">

    {{-- Header --}}
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

    {{-- Success Toast --}}
    @if(session('success'))
        <div id="success-toast" class="fixed top-10 right-10 z-[100] bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 transition-all duration-500 transform">
            <div class="h-6 w-6 bg-emerald-500 rounded-full flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                if(toast) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

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
                            $allSubmissions = $brief->livrables()->where('learner_id', auth()->id())->get();
                            $submissionCount = $allSubmissions->count();
                            
                            // 1. Check if ANY deliverable is validated
                            $isValidated = $allSubmissions->where('is_validated', true)->isNotEmpty();
                            
                            // 2. Check if the LATEST submission was rejected (invalidated)
                            $latestSubmission = $allSubmissions->sortByDesc('created_at')->first();
                            $isInvalidated = $latestSubmission && $latestSubmission->is_validated === false;
                            
                            // 3. Sent but not yet evaluated (is_validated is still null)
                            $isPendingEvaluation = $latestSubmission && is_null($latestSubmission->is_validated);
                        @endphp
                        
                        <div class="group bg-white rounded-2xl border border-slate-100 p-4 hover:border-emerald-500/30 hover:bg-slate-50/30 transition-all duration-200">
                            <div class="flex items-center gap-6">
                                
                                {{-- Status Icon Logic --}}
                                <div class="flex-shrink-0">
                                    @if($isValidated)
                                        {{-- CHECKED GREEN --}}
                                        <div class="h-6 w-6 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    @elseif($isInvalidated)
                                        {{-- RED ICON --}}
                                        <div class="h-6 w-6 bg-rose-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-rose-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                        </div>
                                    @elseif($isPendingEvaluation)
                                        {{-- SOLID GREEN (SENT BUT NOT EVALUATED) --}}
                                        <div class="h-4 w-4 rounded-full bg-emerald-500 border-2 border-emerald-100"></div>
                                    @else
                                        {{-- GRAY (NOT SENT YET) --}}
                                        <div class="h-3 w-3 rounded-full bg-slate-200"></div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors truncate">
                                            {{ $brief->title }}
                                        </h3>
                                        @if($isValidated)
                                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest px-2 py-0.5 bg-emerald-50 rounded-md">Validated</span>
                                        @elseif($isInvalidated)
                                            <span class="text-[9px] font-black text-rose-600 uppercase tracking-widest px-2 py-0.5 bg-rose-50 rounded-md">Needs Revision</span>
                                        @elseif($isPendingEvaluation)
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-2 py-0.5 bg-slate-50 rounded-md">Sent</span>
                                        @endif
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

                                    @if($submissionCount > 0)
                                        <a href="{{ route('learner.briefs.submit', $brief->id) }}" 
                                           class="inline-flex items-center gap-2 bg-slate-100 text-slate-900 px-5 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-emerald-600 hover:text-white border border-slate-200 hover:border-emerald-600 shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                                            Add Work
                                        </a>
                                    @else
                                        <a href="{{ route('learner.briefs.submit', $brief->id) }}" 
                                           class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-emerald-600 hover:-translate-y-0.5 active:scale-95 shadow-md">
                                            Submit
                                        </a>
                                    @endif
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