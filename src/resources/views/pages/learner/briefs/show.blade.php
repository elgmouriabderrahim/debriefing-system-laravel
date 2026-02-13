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

            @if($evaluation)
            <div class="relative pt-4">
                <div class="absolute top-1 left-10 px-4 bg-[#f8fafc] text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] z-10">
                    Instructor Evaluation
                </div>
                <div class="bg-emerald-50/30 border-2 border-emerald-100 rounded-[2.5rem] p-10 space-y-8">
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-emerald-600/50 uppercase tracking-widest">Feedback Message</label>
                        <p class="text-slate-700 font-bold italic text-lg leading-relaxed">
                            "{{ $evaluation->comment ?? 'Evaluation complete.' }}"
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach($evaluation->competences as $comp)
                        <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 bg-slate-900 text-white text-[10px] font-black rounded-lg leading-none">{{ $comp->code }}</span>
                                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ $comp->label }}</h4>
                                </div>
                                <span class="w-fit text-[9px] font-black px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase rounded-full">
                                    Level: {{ str_replace('_', ' ', $comp->pivot->level) }}
                                </span>
                            </div>

                            @php $lvl = strtolower($comp->pivot->level); @endphp
                            <div class="h-2 bg-slate-100 rounded-full flex gap-1.5 p-1">
                                <div class="h-full rounded-full flex-1 {{ in_array($lvl, ['imiter', 's_adapter', 'transposer']) ? 'bg-blue-500' : 'bg-slate-200' }}"></div>
                                <div class="h-full rounded-full flex-1 {{ in_array($lvl, ['s_adapter', 'transposer']) ? 'bg-indigo-500' : 'bg-slate-200' }}"></div>
                                <div class="h-full rounded-full flex-1 {{ $lvl == 'transposer' ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @php $submissions = $brief->livrables()->where('learner_id', auth()->id())->latest()->get(); @endphp
            <div class="space-y-6">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">My Submissions ({{ $submissions->count() }})</h3>
                @forelse($submissions as $sub)
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:border-emerald-200 transition-all group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-4">
                                <div class="h-10 w-10 {{ $sub->is_validated ? 'bg-emerald-500' : ($sub->is_validated === false ? 'bg-rose-500' : 'bg-slate-900') }} text-white rounded-2xl flex items-center justify-center shadow-lg transition-transform group-hover:scale-105">
                                    @if($sub->is_validated) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                    @elseif($sub->is_validated === false) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                    @else <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/></svg> @endif
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $sub->created_at->format('M d, Y • H:i') }}</p>
                                    <a href="{{ $sub->url }}" target="_blank" class="mt-1 text-sm font-black text-blue-600 hover:text-blue-700 break-all flex items-center gap-2">
                                        {{ $sub->url }}
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase {{ $sub->is_validated ? 'bg-emerald-50 text-emerald-600' : ($sub->is_validated === false ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400') }}">
                                {{ $sub->is_validated ? 'Validated' : ($sub->is_validated === false ? 'Revision' : 'Under Review') }}
                            </span>
                        </div>

                        {{-- The Content / Description area --}}
                        @if($sub->content)
                        <div class="mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Submission Notes</label>
                            <p class="text-xs font-bold text-slate-600 leading-relaxed italic">
                                "{{ $sub->content }}"
                            </p>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="py-12 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">No submissions yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar Column --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
                <h3 class="relative z-10 font-bold text-lg mb-2">New Deliverable</h3>
                <p class="relative z-10 text-slate-400 text-sm mb-6 leading-relaxed">Submit a new link for this project.</p>
                <a href="{{ route('learner.briefs.submit', $brief->id) }}" class="relative z-10 block w-full bg-emerald-500 hover:bg-emerald-600 text-white text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20">
                    Submit Work
                </a>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 space-y-6">
                {{-- Required Competences --}}
                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-4">Required Competences</label>
                    <div class="space-y-4">
                        @foreach($brief->competences as $comp)
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-black text-slate-900 px-1.5 py-0.5 bg-slate-100 rounded">{{ $comp->code }}</span>
                                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tight">{{ $comp->label }}</span>
                            </div>
                            <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Goal Level:</span>
                                <span class="text-[9px] font-black uppercase text-emerald-600">
                                    {{ str_replace('_', ' ', $comp->pivot->level ?? 'N/A') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="h-[1px] bg-slate-50"></div>

                {{-- Deadline --}}
                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-3">Deadline</label>
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">{{ \Carbon\Carbon::parse($brief->end_date)->format('F d, Y') }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase italic">{{ \Carbon\Carbon::parse($brief->end_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection