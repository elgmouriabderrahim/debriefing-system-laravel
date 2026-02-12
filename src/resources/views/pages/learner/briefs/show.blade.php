@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto pb-20 pt-8 px-6">
    <div class="mb-8">
        <a href="{{ route('learner.briefs.index') }}" class="inline-flex items-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-emerald-600 transition-colors group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Back to Briefs
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-8 space-y-8">
            <div>
                <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-lg mb-4">
                    {{ $brief->sprint->name ?? 'General Project' }}
                </span>
                <h1 class="text-4xl font-black text-slate-900 leading-tight tracking-tight">{{ $brief->title }}</h1>
            </div>

            {{-- Brief Description --}}
            <div class="prose prose-slate max-w-none">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm text-slate-600 leading-relaxed font-medium">
                    {!! nl2br(e($brief->content)) !!}
                </div>
            </div>

            {{-- NEW: Submission History Timeline --}}
            @php
                $submissions = $brief->livrables()->where('learner_id', auth()->id())->latest()->get();
            @endphp

            @if($submissions->count() > 0)
                <div class="space-y-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-2">My Submissions ({{ $submissions->count() }})</h3>
                    <div class="space-y-4">
                        @foreach($submissions as $sub)
                            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:border-emerald-200 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex gap-4">
                                        {{-- Icon Logic based on your request --}}
                                        @if($sub->is_validated === true)
                                            <div class="h-10 w-10 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        @elseif($sub->is_validated === false && !is_null($sub->is_validated))
                                            <div class="h-10 w-10 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.828a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $sub->created_at->format('M d, Y • H:i') }}</p>
                                            <div class="mt-2 text-sm font-bold text-slate-800 line-clamp-2">
                                                {{ $sub->content }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($sub->is_validated === true)
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded-lg">Validated</span>
                                    @elseif($sub->is_validated === false && !is_null($sub->is_validated))
                                        <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black uppercase rounded-lg">Needs Revision</span>
                                    @else
                                        <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[9px] font-black uppercase rounded-lg">Under Review</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
                
                <h3 class="relative z-10 font-bold text-lg mb-2">New Deliverable</h3>
                <p class="relative z-10 text-slate-400 text-sm mb-6 leading-relaxed">Submit a new link for this project (Design, Plan, or Code).</p>
                
                <a href="{{ route('learner.briefs.submit', $brief->id) }}" 
                   class="relative z-10 block w-full bg-emerald-500 hover:bg-emerald-600 text-white text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:-translate-y-1 active:scale-95 shadow-lg shadow-emerald-500/20">
                    Submit Work
                </a>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 space-y-6">
                {{-- Deadline --}}
                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-3">Deadline</label>
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">{{ \Carbon\Carbon::parse($brief->end_date)->format('F d, Y') }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ \Carbon\Carbon::parse($brief->end_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="h-[1px] bg-slate-50"></div>

                {{-- Target Skills --}}
                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-4">Target Skills</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($brief->competences as $comp)
                            <span class="px-3 py-1.5 bg-slate-50 border border-slate-100 rounded-lg text-[10px] font-black text-slate-600 uppercase tracking-tighter">
                                {{ $comp->code }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="h-[1px] bg-slate-50"></div>

                {{-- Instructor --}}
                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-4">Instructor</label>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($brief->instructor->first_name . ' ' . $brief->instructor->last_name) }}&background=f1f5f9&color=64748b" class="h-10 w-10 rounded-xl border border-slate-100">
                        <p class="text-sm font-bold text-slate-700">{{ $brief->instructor->first_name }} {{ $brief->instructor->last_name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection