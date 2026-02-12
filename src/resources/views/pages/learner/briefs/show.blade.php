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

            <div class="prose prose-slate max-w-none">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm text-slate-600 leading-relaxed font-medium">
                    {!! nl2br(e($brief->content)) !!}
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
                
                <h3 class="relative z-10 font-bold text-lg mb-2">Ready to submit?</h3>
                <p class="relative z-10 text-slate-400 text-sm mb-6 leading-relaxed">Make sure you've covered all the requirements before pushing your work.</p>
                
                <a href="{{ route('learner.briefs.submit', $brief->id) }}" 
                   class="relative z-10 block w-full bg-emerald-500 hover:bg-emerald-600 text-white text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:-translate-y-1 active:scale-95 shadow-lg shadow-emerald-500/20">
                    {{ $hasSubmitted ? 'Update Submission' : 'Submit Project' }}
                </a>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 space-y-6">
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

                <div>
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-4">Instructor</label>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($brief->instructor->first_name . ' ' . $brief->instructor->last_name) }}&background=f1f5f9&color=64748b" class="h-10 w-10 rounded-xl border border-slate-100">
                        <p class="text-sm font-bold text-slate-700">{{ $brief->instructor->first_name }} {{ $brief->instructor->last_name }}</p>
                    </div>
                </div>
            </div>

            @if($hasSubmitted)
                <div class="bg-emerald-50 border border-emerald-100 rounded-[2rem] p-6 text-center shadow-sm">
                    <p class="text-emerald-700 font-black text-[10px] uppercase tracking-[0.2em]">Work Received</p>
                    <p class="text-[10px] text-emerald-500 mt-1 italic font-medium">You can still update until the deadline.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection