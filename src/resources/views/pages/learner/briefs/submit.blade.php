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
                    <input type="url" name="link" required placeholder="https://..." class="w-full h-14 px-6 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:outline-none transition-all">
                </div>

                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Description (e.g., "Design Phase", "V1 Code")</label>
                    <textarea name="notes" rows="3" placeholder="Explain what this deliverable contains..." class="w-full p-5 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:outline-none transition-all resize-none"></textarea>
                </div>
            </div>

            <button type="submit" class="w-full h-16 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-lg active:scale-95">
                Send Deliverable
            </button>
        </form>
    </div>

    {{-- History Section: Shows what they already sent --}}
    @php
        $previousSubmissions = $brief->livrables()->where('learner_id', auth()->id())->latest()->get();
    @endphp

    @if($previousSubmissions->count() > 0)
    <div class="space-y-4">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Previous Submissions ({{ $previousSubmissions->count() }})</h3>
        <div class="space-y-2">
            @foreach($previousSubmissions as $sub)
                <div class="bg-white/60 border border-slate-100 p-4 rounded-2xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3"/></svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-600 uppercase tracking-tight">Sent on {{ $sub->created_at->format('M d, H:i') }}</span>
                    </div>
                    @if($sub->is_validated)
                        <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md uppercase">Validated</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection