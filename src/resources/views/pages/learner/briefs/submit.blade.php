@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto pt-12 pb-20 px-6">
    <div class="mb-10 flex items-center justify-between">
        <a href="{{ route('learner.briefs.show', $brief->id) }}" class="inline-flex items-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5"/></svg>
            Back to Project
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] p-12 shadow-xl shadow-slate-200/50">
        <header class="mb-10">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] block mb-2">Project Delivery</span>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $brief->title }}</h1>
        </header>

        <form action="{{ route('learner.livrables.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="brief_id" value="{{ $brief->id }}">

            <div class="space-y-4">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">
                    Work Link (GitHub, Drive, or URL)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.828a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" stroke-width="2"/></svg>
                    </div>
                    <input type="url" name="content" required 
                           value="{{ $livrable->content ?? '' }}"
                           placeholder="https://github.com/your-username/repo"
                           class="w-full h-16 pl-12 pr-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-300">
                </div>
                <p class="text-[10px] text-slate-400 italic ml-1">Double check your link visibility before submitting.</p>
            </div>

            <button type="submit" class="w-full h-16 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-lg hover:-translate-y-1 active:scale-95">
                {{ $hasSubmitted ? 'Update My Work' : 'Confirm Submission' }}
            </button>
        </form>
    </div>
</div>
@endsection