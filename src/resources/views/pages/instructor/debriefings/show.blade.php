@extends('layouts.main')
@section('title', 'Project Deliverables - ' . $brief->title)

@section('content')
<div class="min-h-screen bg-[#FDFDFE] antialiased pb-20">
    <div class="w-full border-b border-slate-100 bg-white/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-[1250px] mx-auto px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('instructor.debriefings.index') }}" class="p-2 hover:bg-slate-50 rounded-full transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-500 leading-none mb-1">Brief Review</span>
                    <span class="text-xs font-bold text-slate-900 leading-none truncate max-w-[200px]">{{ $brief->title }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1250px] mx-auto px-8 pt-12">
        <div class="grid grid-cols-12 gap-12">
            
            <div class="col-span-12 lg:col-span-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-900">Student Deliverables</h3>
                    <div class="h-px flex-grow mx-6 bg-slate-100"></div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        {{ $brief->livrables->unique('learner_id')->count() }} / {{ $totalLearners }} Submitted
                    </span>
                </div>

                <div class="space-y-4">
                    @php
                        $allLearners = $brief->sprint->classrooms->flatMap->learners->unique('id');
                    @endphp

                    @forelse($allLearners as $learner)
                        @php 
                            $submissions = $brief->livrables->where('learner_id', $learner->id);
                            $hasSubmitted = $submissions->isNotEmpty();
                        @endphp

                        <div class="group bg-white border {{ $hasSubmitted ? 'border-slate-100' : 'border-rose-100 bg-rose-50/20' }} rounded-[2rem] p-6 shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-2xl {{ $hasSubmitted ? 'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600' : 'bg-rose-100 text-rose-600 group-hover:bg-rose-600' }} flex items-center justify-center group-hover:text-white transition-all">
                                        <span class="text-xs font-black">
                                            {{ strtoupper(substr($learner->first_name, 0, 1) . substr($learner->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-slate-900">{{ $learner->first_name }} {{ $learner->last_name }}</h4>
                                        @if($hasSubmitted)
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $submissions->count() }} Submissions</p>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md bg-rose-100 text-rose-600 text-[8px] font-black uppercase tracking-widest">Missing Submission</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <a href="{{ route('instructor.debriefings.debrief', [$brief->id, $learner->id]) }}" 
                                   class="flex items-center gap-2 px-4 py-2 {{ $hasSubmitted ? 'bg-slate-900' : 'bg-slate-400 pointer-events-none opacity-50' }} text-white rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200">
                                    <span>Debrief Student</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5"/></svg>
                                </a>
                            </div>

                            <div class="space-y-2">
                                @forelse($submissions as $livrable)
                                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="h-2 w-2 rounded-full bg-emerald-400"></div>
                                            <div class="text-xs text-slate-600 font-medium truncate">
                                                @if(filter_var($livrable->content, FILTER_VALIDATE_URL))
                                                    <a href="{{ $livrable->content }}" target="_blank" class="text-indigo-600 hover:underline font-bold">{{ $livrable->content }}</a>
                                                @else
                                                    {{ $livrable->content }}
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 whitespace-nowrap ml-4">{{ $livrable->created_at->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-2">
                                        <p class="text-[10px] font-bold text-rose-400 italic">No files provided for evaluation.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="py-20 flex flex-col items-center justify-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">No learners found for this sprint</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="sticky top-28 space-y-8">
                    <div class="p-8 rounded-[2.5rem] bg-slate-900 text-white shadow-2xl overflow-hidden relative">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-6">Group Progress</p>
                            @php 
                                $percent = $totalLearners > 0 ? round(($brief->livrables->unique('learner_id')->count() / $totalLearners) * 100) : 0;
                            @endphp
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-6xl font-black tracking-tighter">{{ $percent }}<span class="text-2xl text-indigo-500">%</span></span>
                            </div>
                            <p class="text-[11px] font-bold text-slate-400 mb-8 italic">Classroom engagement</p>
                            <div class="h-1.5 w-full bg-slate-800 rounded-full">
                                <div class="h-full bg-indigo-500 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection