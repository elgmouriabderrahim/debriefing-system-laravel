@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto pt-12 pb-20 px-6 space-y-8">
    
    <div class="mb-2">
        <a href="{{ route('learner.briefs.show', $brief->id) }}" class="inline-flex items-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Project
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] p-12 shadow-xl shadow-slate-200/50">
        <header class="mb-10">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] block mb-2">New Deliverable</span>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $brief->title }}</h1>
            <p class="text-slate-400 text-xs font-bold mt-2 uppercase tracking-wide">Submit your design, planification, or code links below.</p>
        </header>

        <form action="{{ route('learner.livrables.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="brief_id" value="{{ $brief->id }}">

            <div class="space-y-6">
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Work Link</label>
                    <input type="url" name="url" required placeholder="https://github.com/..." class="w-full h-14 px-6 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:outline-none transition-all">
                </div>

                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Description (Optional)</label>
                    <textarea name="content" rows="3" placeholder="Explain what this deliverable contains..." class="w-full p-5 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:outline-none transition-all resize-none"></textarea>
                </div>
            </div>

            <button type="submit" class="w-full h-16 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-lg active:scale-95">
                Send Deliverable
            </button>
        </form>
    </div>

    @php
        $previousSubmissions = $brief->livrables()->where('learner_id', auth()->id())->latest()->get();
    @endphp

    @if($previousSubmissions->count() > 0)
    <div class="space-y-4">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Previous Submissions ({{ $previousSubmissions->count() }})</h3>
        <div class="space-y-3">
            @foreach($previousSubmissions as $sub)
                <div class="bg-white border border-slate-100 p-5 rounded-3xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <div class="h-10 w-10 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" stroke-width="2"/></svg>
                        </div>
                        <div class="flex flex-col overflow-hidden">
                            <a href="{{ $sub->url }}" target="_blank" class="text-xs font-bold text-indigo-600 truncate hover:underline">{{ $sub->url }}</a>
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">Sent {{ $sub->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if($sub->content)
                            <button title="{{ $sub->content }}" class="h-8 w-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" stroke-width="2"/></svg>
                            </button>
                        @endif
                        
                        <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-xl uppercase">Sent</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection