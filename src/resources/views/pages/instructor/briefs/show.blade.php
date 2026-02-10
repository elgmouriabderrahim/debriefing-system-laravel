@extends('layouts.main')

@section('content')
<div class="max-w-[1300px] mx-auto pb-32 px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
        <div class="flex items-center gap-6">
            <a href="{{ route('instructor.briefs.index') }}" 
               class="h-14 w-14 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-50/20 transition-all group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-[10px] font-black text-indigo-600 uppercase tracking-widest">Library</span>
                    <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Viewing Mode</span>
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">{{ $brief->title }}</h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('instructor.briefs.edit', $brief->id) }}" 
               class="px-6 py-4 bg-white border border-slate-200 text-slate-600 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:border-indigo-600 hover:text-indigo-600 transition-all shadow-sm">
                Edit Brief
            </a>
            <button class="px-8 py-4 bg-slate-900 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 transition-all">
                Export PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        <div class="lg:col-span-8">
            <div class="bg-white border border-slate-50 rounded-[3.5rem] p-12 lg:p-16 shadow-[0_20px_50px_rgba(0,0,0,0.02)] relative overflow-hidden">
                <div class="flex flex-wrap gap-3 mb-12">
                    @foreach($brief->competences as $comp)
                        <div class="group relative">
                            <span class="px-4 py-2 bg-slate-50 border border-slate-100 text-slate-600 text-[10px] font-black rounded-xl uppercase tracking-widest hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all cursor-default">
                                {{ $comp->code }}
                            </span>
                            <div class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2 w-56 p-4 bg-slate-900 text-white text-[10px] font-medium rounded-2xl opacity-0 group-hover:opacity-100 transition-all pointer-events-none z-20 shadow-2xl scale-95 group-hover:scale-100 origin-bottom leading-relaxed">
                                <span class="block text-indigo-400 font-black mb-1 uppercase tracking-widest">{{ $comp->code }}</span>
                                {{ $comp->label }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <article class="prose prose-slate prose-lg max-w-none 
                    prose-headings:font-black prose-headings:tracking-tighter prose-headings:text-slate-900
                    prose-p:text-slate-600 prose-p:leading-relaxed
                    prose-strong:font-black prose-strong:text-slate-900
                    prose-blockquote:border-l-0 prose-blockquote:bg-slate-50 prose-blockquote:p-8 prose-blockquote:rounded-[2rem] prose-blockquote:not-italic prose-blockquote:font-bold prose-blockquote:text-slate-700">
                    
                    {!! nl2br(e($brief->content)) !!}
                    
                </article>
            </div>
        </div>

        <div class="lg:col-span-4 sticky top-10 space-y-8">
            <div class="bg-[#0F172A] rounded-[3rem] p-10 text-white shadow-2xl shadow-indigo-100">
                <h4 class="text-[11px] font-black uppercase tracking-[0.4em] text-indigo-400/80 mb-10">Quick Details</h4>
                
                <div class="space-y-8">
                    <div class="flex items-start gap-5">
                        <div class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-indigo-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Timeline</p>
                            <p class="text-base font-bold">{{ \Carbon\Carbon::parse($brief->start_date)->format('d M') }} — {{ \Carbon\Carbon::parse($brief->end_date)->format('d M, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-indigo-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Project Format</p>
                            <p class="text-base font-bold capitalize">{{ $brief->type }} Delivery</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-indigo-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Current Sprint</p>
                            <p class="text-base font-bold">{{ $brief->sprint->name ?? 'None Assigned' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-10 border-t border-white/5">
                    <button class="group w-full py-5 bg-indigo-600 text-white rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white hover:text-slate-900 transition-all duration-500 flex items-center justify-center gap-3">
                        Assign to Students
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 flex items-center justify-between group cursor-default">
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Live Activity</h4>
                    <p class="text-sm font-bold text-slate-900">Total Submissions</p>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-5xl font-black text-slate-900 tracking-tighter group-hover:text-indigo-600 transition-colors">{{ $brief->livrables_count }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection