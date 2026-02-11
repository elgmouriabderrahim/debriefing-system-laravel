@extends('layouts.main')
@section('title','Debriefings-system | Edit brief')
@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="flex items-end justify-between mb-12">
        <div class="flex items-start gap-5">
            <a href="{{ route('instructor.briefs.index') }}" 
               class="h-12 w-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:shadow-sm transition-all group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="px-2 py-0.5 rounded-md bg-amber-50 text-[10px] font-black text-amber-600 uppercase tracking-widest border border-amber-100">Edit Mode</span>
                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ID: #{{ $brief->id }}</span>
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Modify Brief</h1>
                <p class="text-slate-500 font-medium mt-2 italic">Refining the technical requirements for this scenario.</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('instructor.briefs.index') }}" 
               class="flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-rose-500 hover:bg-rose-50/50 transition-all">
                Discard Changes
            </a>

            <button form="briefForm" type="submit" 
                    class="px-8 py-3 bg-slate-900 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100">
                Update Brief
            </button>
        </div>
    </div>

    <form id="briefForm" action="{{ route('instructor.briefs.update', $brief->id) }}" method="POST" class="space-y-10">
        @csrf
        @method('PUT')
        
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm space-y-8">
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Project Identity</label>
                <input type="text" name="title" value="{{ old('title', $brief->title) }}" 
                    class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-xl font-bold text-slate-800 outline-none transition-all">
                @error('title') <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Target Competencies</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($competences as $competence)
                    <label class="group relative cursor-pointer">
                        <input type="checkbox" name="competence_ids[]" value="{{ $competence->id }}" class="peer sr-only" 
                            {{ in_array($competence->id, old('competence_ids', $selectedCompetences)) ? 'checked' : '' }}>
                        <div class="px-5 py-4 rounded-2xl border-2 border-slate-50 bg-slate-50 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 group-hover:border-slate-200">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[9px] font-black text-slate-400 group-hover:text-slate-500 uppercase tracking-tighter peer-checked:group-hover:text-emerald-600">{{ $competence->code }}</span>
                                <div class="w-2 h-2 rounded-full bg-slate-200 peer-checked:group-[]:bg-emerald-500 transition-colors"></div>
                            </div>
                            <p class="text-sm font-bold text-slate-700 peer-checked:group-[]:text-emerald-900 leading-tight">{{ $competence->label }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Format</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(['individual', 'group'] as $type)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="{{ $type }}" class="peer sr-only" {{ old('type', $brief->type) == $type ? 'checked' : '' }}>
                            <div class="p-4 text-center rounded-2xl border-2 border-slate-50 bg-slate-50 font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all uppercase text-[10px] tracking-widest">
                                {{ $type }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Target Sprint</label>
                    <div class="relative">
                        <select name="sprint_id" class="w-full px-8 py-4.5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all appearance-none">
                            @foreach($sprints as $sprint)
                                <option value="{{ $sprint->id }}" {{ $brief->sprint_id == $sprint->id ? 'selected' : '' }}>{{ $sprint->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $brief->start_date) }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Deadline</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $brief->end_date) }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute -top-3 left-10 px-4 bg-[#f8fafc] text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] z-10">
                Detailed Brief Content
            </div>
            <div class="bg-white border-2 border-dashed border-slate-200 group-focus-within:border-indigo-500 group-focus-within:bg-white transition-all rounded-[3rem] overflow-hidden">
                <textarea name="content" rows="15" 
                    class="focus:outline-none w-full p-12 bg-transparent border-none focus:ring-0 text-lg text-slate-600 leading-relaxed font-medium resize-none min-h-[500px]">{{ old('content', $brief->content) }}</textarea>
                
                <div class="bg-slate-50 px-12 py-4 border-t border-slate-100 flex justify-between items-center text-slate-400">
                    <span class="text-[10px] font-black uppercase tracking-widest italic">Supports Github Flavored Markdown</span>
                    <div class="flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection