@extends('layouts.main')
@section('title', 'Debriefing: ' . $learner->first_name)

@section('content')
@php
    $existingDebrief = $brief->debriefings()->where('learner_id', $learner->id)->first();
@endphp

<div class="min-h-screen bg-[#FDFDFE] antialiased pb-20">
    <div class="w-full border-b border-slate-100 bg-white/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-[1250px] mx-auto px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('instructor.debriefings.show', $brief->id) }}" class="p-2 hover:bg-slate-50 rounded-full transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-500 leading-none mb-1">Evaluating Student</span>
                    <span class="text-xs font-bold text-slate-900 leading-none">{{ $learner->first_name }} {{ $learner->last_name }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase rounded-lg">{{ $brief->title }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-[1250px] mx-auto px-8 pt-12">
        <div class="grid grid-cols-12 gap-12">
            
            <div class="col-span-12 lg:col-span-7">
                <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-8">Submitted Deliverables</h3>
                
                <div class="space-y-6">
                    @forelse($submissions as $submission)
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Submission #{{ $loop->iteration }}</span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $submission->created_at->format('M d, Y • H:i') }}</span>
                        </div>
                        
                        <div class="space-y-4">
                            @if($submission->url)
                            <div class="flex items-center justify-between p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 105.656 5.656l-1.1 1.1" stroke-width="2"/></svg>
                                    <span class="text-xs font-bold text-indigo-600 truncate">{{ $submission->url }}</span>
                                </div>
                                <a href="{{ $submission->url }}" target="_blank" class="flex-shrink-0 h-9 px-4 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-100">
                                    Visit Link
                                </a>
                            </div>
                            @endif

                            @if($submission->content)
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Commentary / Notes</p>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $submission->content }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold italic">No submissions found.</p>
                    </div>
                    @endforelse

                    @if($existingDebrief)
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Instructor Evaluation</span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $existingDebrief->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($existingDebrief->competences as $c)
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[9px] font-black uppercase text-indigo-500 tracking-widest">{{ $c->code }}</span>
                                        <span class="text-xs font-bold text-slate-900">{{ $c->label }}</span>
                                    </div>
                                    <div class="px-4 py-2 bg-white border border-slate-200 rounded-xl">
                                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Level:</span>
                                        <span class="text-[10px] font-black uppercase text-indigo-600">{{ $c->level }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @if($existingDebrief->comment)
                            <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3">Feedback Provided</p>
                                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $existingDebrief->comment }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-span-12 lg:col-span-5">
                <div class="sticky top-28">
                    <form action="{{ route('instructor.debriefings.store', [$brief->id, $learner->id]) }}" method="POST" class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/50">
                        @csrf
                        <h3 class="text-xl font-black text-slate-900 mb-2">Evaluation</h3>
                        <p class="text-xs text-slate-400 font-medium mb-8">Assess skills and provide constructive feedback.</p>

                        @if(!$existingDebrief)
                        <div class="space-y-6 mb-8">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Target Competencies</p>
                            @foreach($brief->competences as $comp)
                            <div class="flex flex-col gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <span class="text-xs font-bold text-slate-700">{{ $comp->code }} - {{ $comp->label }}</span>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(['Imiter', 'S\'adapter', 'Transposer'] as $level)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="comp[{{ $comp->id }}]" value="{{ strtolower($level) }}" class="peer hidden" required>
                                        <div class="py-2 text-center text-[9px] font-black uppercase rounded-lg border border-slate-200 bg-white text-slate-400 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all">
                                            {{ $level }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="space-y-4 mb-8">
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Instructor Feedback</label>
                            <textarea name="feedback" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm outline-none focus:bg-white focus:border-indigo-500 transition-all" placeholder="Write your thoughts...">{{ $existingDebrief->comment ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="w-full h-14 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
                            {{ $existingDebrief ? 'Update Comment' : 'Evaluate' }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection