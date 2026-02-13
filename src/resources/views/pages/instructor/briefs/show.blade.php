@extends('layouts.main')
@section('title','Debriefings-system | brief')
@section('content')
<div class="min-h-screen bg-[#FDFDFE] antialiased text-slate-900 pb-20 z-10">
    <div class="w-full border-b border-slate-100 bg-white/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-[1250px] mx-auto px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('instructor.briefs.index') }}" class="p-2 hover:bg-slate-50 rounded-full transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-500 leading-none mb-1">Active Brief</span>
                    <span class="text-xs font-bold text-slate-900 leading-none truncate max-w-[200px]">{{ $brief->title }}</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex -space-x-2">
                    {{-- Fixed: Unique avatars --}}
                    @foreach($brief->livrables->unique('learner_id')->take(4) as $liv)
                        <div class="h-7 w-7 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[8px] font-bold text-slate-500">
                            {{ strtoupper(substr($liv->learner->first_name, 0, 1)) }}
                        </div>
                    @endforeach
                    @if($brief->livrables->unique('learner_id')->count() > 4)
                        <div class="h-7 w-7 rounded-full border-2 border-white bg-slate-900 flex items-center justify-center text-[8px] font-bold text-white">
                            +{{ $brief->livrables->unique('learner_id')->count() - 4 }}
                        </div>
                    @endif
                </div>
                <div class="h-6 w-px bg-slate-100"></div>
                <a href="{{ route('instructor.briefs.edit', $brief->id) }}" class="h-8 px-4 inline-flex items-center bg-slate-900 text-white rounded-full text-[10px] font-bold tracking-wide hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                    Edit Project
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-[1250px] mx-auto px-8 pt-12">
        <div class="grid grid-cols-12 gap-16">
            
            <div class="col-span-12 lg:col-span-8">
                <header class="mb-12">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest">{{ $brief->type }}</span>
                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $brief->sprint->name }}</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tight leading-[1.1] mb-8">
                        {{ $brief->title }}
                    </h1>
                </header>

                <article class="prose prose-slate max-w-none 
                    prose-p:text-slate-500 prose-p:text-[15px] prose-p:leading-relaxed
                    prose-strong:text-slate-900 prose-headings:text-slate-900">
                    {!! nl2br(e($brief->content)) !!}
                </article>

                <div class="mt-24">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-900">Deliverables</h3>
                        <div class="h-px flex-grow mx-6 bg-slate-100"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $brief->livrables->unique('learner_id')->count() }} / {{ $totalLearners }} Students</span>
                    </div>

                    <div class="grid grid-cols-1 gap-2">
                        @forelse($brief->livrables->unique('learner_id') as $livrable)
                        <div class="group flex items-center shadow-sm justify-between p-3 rounded-2xl border border-transparent hover:border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-slate-200/40 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-2xl bg-slate-50 flex items-center justify-center group-hover:bg-indigo-600 transition-colors">
                                    <span class="text-[11px] font-black text-slate-400 group-hover:text-white">
                                        {{ strtoupper(substr($livrable->learner->first_name, 0, 1) . substr($livrable->learner->last_name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">{{ $livrable->learner->first_name }} {{ $livrable->learner->last_name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $livrable->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-12 flex flex-col items-center justify-center bg-slate-50/50 rounded-[2.5rem] border border-dashed border-slate-200">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Awaiting Submissions</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="sticky top-28 space-y-12">
                    
                    <div class="relative p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5">
                            <svg class="w-24 h-24 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3v6h8V3h-8zm0 18h8v-6h-8v6zM3 21h8v-6H3v6zm0-18v6h8V3H3z"/></svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-6">Group Velocity</p>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-6xl font-black text-slate-900 tracking-tighter">{{ $totalLearners > 0 ? round(($brief->livrables->unique('learner_id')->count() / $totalLearners) * 100) : 0 }}<span class="text-2xl text-slate-300">%</span></span>
                        </div>
                        <p class="text-[11px] font-bold text-slate-400 mb-8">Classroom engagement rate</p>
                        <div class="h-1.5 w-full bg-slate-100 rounded-full">
                            <div class="h-full bg-slate-900 rounded-full transition-all duration-1000" style="width: {{ $totalLearners > 0 ? ($brief->livrables->unique('learner_id')->count() / $totalLearners) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="px-4 space-y-10">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Details</h4>
                            <div class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] font-bold text-slate-400">Timeline</span>
                                    <span class="text-xs font-black text-slate-900 tracking-tight">{{ \Carbon\Carbon::parse($brief->start_date)->format('M d') }} — {{ \Carbon\Carbon::parse($brief->end_date)->format('M d') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] font-bold text-slate-400">Phase</span>
                                    <span class="text-xs font-black text-slate-900 tracking-tight">{{ $brief->sprint->name }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Required Competencies</h4>
                            <div class="space-y-3">
                                @foreach($brief->competences as $comp)
                                    <div class="group flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-200 transition-all">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-tighter">{{ $comp->code }}</span>
                                            <span class="text-[11px] font-bold text-slate-700 leading-tight">{{ $comp->label }}</span>
                                        </div>
                                        
                                        <div class="px-2 py-1 rounded-lg bg-white border border-slate-200 shadow-sm">
                                            <span class="text-[9px] font-black text-slate-500 uppercase italic">
                                                {{ str_replace('_', ' ', $comp->pivot->level) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection