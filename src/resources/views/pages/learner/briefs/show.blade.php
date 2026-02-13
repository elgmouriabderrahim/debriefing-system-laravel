@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto pb-20 pt-8 px-6">
    {{-- Navigation --}}
    <div class="mb-8">
        <a href="{{ route('learner.briefs.index') }}" class="inline-flex items-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-emerald-600 transition-colors group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Back to Briefs
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        {{-- Main Column --}}
        <div class="lg:col-span-8 space-y-10">
            <div>
                <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-lg mb-4">
                    {{ $brief->sprint->name ?? 'General Project' }}
                </span>
                <h1 class="text-4xl font-black text-slate-900 leading-tight tracking-tight">{{ $brief->title }}</h1>
            </div>

            {{-- Brief Description --}}
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm text-slate-600 leading-relaxed font-medium">
                {!! nl2br(e($brief->content)) !!}
            </div>

            @php
                $evaluation = auth()->user()->debriefingsAsLearner()
                                ->where('brief_id', $brief->id)
                                ->with('competences')
                                ->latest()
                                ->first();
            @endphp

            @php $submissions = $brief->livrables()->where('learner_id', auth()->id())->latest()->get(); @endphp
            <div class="space-y-6">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Submission History</h3>
                @forelse($submissions as $sub)
                    @php $subValid = $sub->is_validated; @endphp
                    <div class="bg-white border rounded-[2rem] p-8 transition-all hover:shadow-lg shadow-sm {{ $subValid === true ? 'border-emerald-200 bg-emerald-50/10' : ($subValid === false ? 'border-rose-200 bg-rose-50/10' : 'border-slate-100') }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-4">
                                <div class="h-12 w-12 rounded-2xl flex items-center justify-center shadow-lg transition-transform {{ $subValid === true ? 'bg-emerald-500 text-white' : ($subValid === false ? 'bg-rose-500 text-white' : 'bg-slate-900 text-white') }}">
                                    @if($subValid === true) <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                    @elseif($subValid === false) <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                    @else <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/></svg> @endif
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $sub->created_at->format('M d, Y • H:i') }}</p>
                                    <a href="{{ $sub->url }}" target="_blank" class="mt-1 text-sm font-black {{ $subValid === true ? 'text-emerald-700' : ($subValid === false ? 'text-rose-700' : 'text-blue-600') }} hover:underline flex items-center gap-2">
                                        {{ Str::limit($sub->url, 45) }}
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                </div>
                            </div>
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm {{ $subValid === true ? 'bg-emerald-500 text-white' : ($subValid === false ? 'bg-rose-500 text-white' : 'bg-slate-100 text-slate-400') }}">
                                {{ $subValid === true ? 'Validated' : ($subValid === false ? 'Rejected' : 'Pending Review') }}
                            </span>
                        </div>

                        @if($sub->content)
                        <div class="mt-4 p-5 rounded-2xl border {{ $subValid === true ? 'bg-white/60 border-emerald-100' : ($subValid === false ? 'bg-white/60 border-rose-100' : 'bg-slate-50 border-slate-100') }}">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-2">Learner Notes</label>
                            <p class="text-sm font-bold text-slate-700 leading-relaxed italic">
                                "{{ $sub->content }}"
                            </p>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="py-16 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-100">
                        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em]">No work submitted yet</p>
                    </div>
                @endforelse
            </div>
            @if($evaluation)
            <div class="relative pt-4">
                <div class="absolute top-1 left-10 px-4 bg-[#f8fafc] text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] z-10">
                    Instructor Evaluation
                </div>
                <div class="bg-white border border-slate-200 rounded-[2.5rem] p-10 shadow-xl shadow-slate-100 space-y-8">
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Feedback Message</label>
                        <p class="text-slate-700 font-bold italic text-lg leading-relaxed">
                            "{{ $evaluation->comment ?? 'Evaluation complete.' }}"
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach($evaluation->competences as $comp)
                        @php 
                            $isValidated = $comp->pivot->validate === 'valide'; 
                            $lvl = strtolower($comp->pivot->level);
                        @endphp
                        <div class="p-6 rounded-3xl border transition-all {{ $isValidated ? 'bg-emerald-50/50 border-emerald-100 shadow-emerald-50' : 'bg-rose-50/50 border-rose-100 shadow-rose-50' }} shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 bg-slate-900 text-white text-[10px] font-black rounded-lg leading-none">{{ $comp->code }}</span>
                                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ $comp->label }}</h4>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <span class="text-[9px] font-black px-3 py-1 bg-white border border-slate-100 text-slate-600 uppercase rounded-full shadow-sm">
                                        Level: {{ str_replace('_', ' ', $comp->pivot->level) }}
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase border {{ $isValidated ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-rose-500 text-white border-rose-500' }}">
                                        {{ $isValidated ? 'Validated' : 'Non Validated' }}
                                    </span>
                                </div>
                            </div>

                            <div class="h-2 bg-white/50 border border-white rounded-full flex gap-1.5 p-1">
                                <div class="h-full rounded-full flex-1 {{ in_array($lvl, ['imiter', 's_adapter', 'transposer']) ? ($isValidated ? 'bg-emerald-500' : 'bg-rose-500') : 'bg-slate-200' }}"></div>
                                <div class="h-full rounded-full flex-1 {{ in_array($lvl, ['s_adapter', 'transposer']) ? ($isValidated ? 'bg-emerald-500' : 'bg-rose-500') : 'bg-slate-200' }}"></div>
                                <div class="h-full rounded-full flex-1 {{ $lvl == 'transposer' ? ($isValidated ? 'bg-emerald-500' : 'bg-rose-500') : 'bg-slate-200' }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-2xl shadow-slate-200 relative overflow-hidden group">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/20 blur-3xl rounded-full group-hover:bg-emerald-500/30 transition-all"></div>
                <h3 class="relative z-10 font-bold text-lg mb-2 tracking-tight">New Deliverable</h3>
                <p class="relative z-10 text-slate-400 text-sm mb-6 leading-relaxed">Ready to show your progress? Submit a new link below.</p>
                <a href="{{ route('learner.briefs.submit', $brief->id) }}" class="relative z-10 block w-full bg-emerald-500 hover:bg-emerald-600 text-white text-center py-4 rounded-2xl font-black text-xs uppercase tracking-[0.15em] transition-all shadow-lg shadow-emerald-500/30 active:scale-95">
                    Submit Project Work
                </a>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 space-y-8 shadow-sm">
                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-5">Target Objectives</label>
                    <div class="space-y-4">
                        @foreach($brief->competences as $comp)
                        <div class="group">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-black text-white px-2 py-0.5 bg-slate-900 rounded-md group-hover:bg-emerald-500 transition-colors">{{ $comp->code }}</span>
                                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tight">{{ $comp->label }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 group-hover:border-emerald-100 transition-all">
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic">Target</span>
                                <span class="text-[9px] font-black uppercase text-emerald-600">
                                    {{ str_replace('_', ' ', $comp->pivot->level ?? 'N/A') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="h-[1px] bg-slate-50"></div>

                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-4">Closing Date</label>
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 shadow-sm shadow-rose-50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 leading-none mb-1">{{ \Carbon\Carbon::parse($brief->end_date)->format('F d, Y') }}</p>
                            <p class="text-[10px] font-bold text-rose-400 uppercase italic">{{ \Carbon\Carbon::parse($brief->end_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection