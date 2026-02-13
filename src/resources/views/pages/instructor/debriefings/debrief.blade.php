@extends('layouts.main')
@section('title', 'Debriefing: ' . $learner->first_name)

@section('content')
<div class="min-h-screen bg-[#FDFDFE] antialiased pb-20">
    {{-- Top Navigation Bar --}}
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
            
            {{-- LEFT: Submissions --}}
            <div class="col-span-12 lg:col-span-6">
                <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-8">Submitted Deliverables</h3>
                <div class="space-y-6">
                    @forelse($submissions as $submission)
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Submission #{{ $loop->iteration }}</span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $submission->created_at->format('M d, H:i') }}</span>
                        </div>
                        
                        <div class="space-y-4">
                            @if($submission->url)
                            <div class="flex items-center justify-between p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                                <span class="text-xs font-bold text-indigo-600 truncate mr-4">{{ $submission->url }}</span>
                                <a href="{{ $submission->url }}" target="_blank" class="h-9 px-4 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase flex items-center gap-2 shadow-lg shadow-indigo-100">Visit</a>
                            </div>
                            @endif
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-slate-50 p-6 rounded-2xl">{{ $submission->content }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold italic">No submissions found.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT: Evaluation Form --}}
            <div class="col-span-12 lg:col-span-6">
                <div class="sticky top-28">
                    <form action="{{ route('instructor.debriefings.store', [$brief->id, $learner->id]) }}" method="POST" class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/50">
                        @csrf
                        <h3 class="text-xl font-black text-slate-900 mb-2">Evaluation Panel</h3>
                        <p class="text-xs text-slate-400 font-medium mb-8">Assess achieved levels and validate competencies.</p>

                        <div class="space-y-6 mb-8">
                            @foreach($brief->competences as $comp)
                            @php
                                // Check if this competence was already evaluated in an existing debrief
                                $eval = $existingDebrief ? $existingDebrief->competences->where('id', $comp->id)->first() : null;
                                $currentLevel = $eval ? $eval->pivot->level : '';
                                $currentStatus = $eval ? $eval->pivot->validate : 'pending';
                            @endphp

                            <div class="p-5 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em]">{{ $comp->code }}</span>
                                        <h4 class="text-xs font-black text-slate-900 leading-tight">{{ $comp->label }}</h4>
                                    </div>
                                    <div class="px-2 py-1 bg-white border border-slate-200 rounded-lg">
                                        <span class="text-[8px] font-black text-slate-400 uppercase italic">Goal: {{ str_replace('_', ' ', $comp->pivot->level) }}</span>
                                    </div>
                                </div>

                                {{-- Hidden ID for the Controller --}}
                                <input type="hidden" name="competences[{{ $comp->id }}][id]" value="{{ $comp->id }}">

                                {{-- Level Selection --}}
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    @foreach(['imiter', 's_adapter', 'transposer'] as $level)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="competences[{{ $comp->id }}][level]" value="{{ $level }}" class="peer hidden" {{ $currentLevel == $level ? 'checked' : '' }} required>
                                        <div class="py-2 text-center text-[9px] font-black uppercase rounded-xl border border-slate-200 bg-white text-slate-400 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all">
                                            {{ str_replace('_', ' ', $level) }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                                {{-- Validation Status --}}
                                <div class="flex gap-2">
                                    @foreach(['valide' => 'emerald', 'non_valide' => 'rose', 'pending' => 'slate'] as $status => $color)
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="competences[{{ $comp->id }}][validate]" value="{{ $status }}" class="peer hidden" {{ $currentStatus == $status ? 'checked' : '' }} required>
                                        <div class="py-1.5 text-center text-[8px] font-black uppercase rounded-lg border border-slate-200 bg-white text-slate-400 
                                            peer-checked:bg-{{ $color }}-500 peer-checked:text-white peer-checked:border-{{ $color }}-500 transition-all">
                                            {{ str_replace('_', ' ', $status) }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 mb-8">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Global Feedback</label>
                            <textarea name="feedback" rows="4" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm outline-none focus:bg-white focus:border-indigo-500 transition-all" placeholder="Enter evaluation notes...">{{ $existingDebrief->comment ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="w-full h-14 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
                            {{ $existingDebrief ? 'Update Evaluation' : 'Confirm & Save' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection