@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="flex items-center justify-between mb-12">
        <div>
            <a href="{{ route('instructor.briefs.index') }}" class="inline-flex items-center text-xs font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-3 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                Back to Briefs
            </a>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Draft New Brief</h1>
            <p class="text-slate-500 font-medium mt-1">Design a new learning scenario for your students.</p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('instructor.briefs.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">Discard Draft</a>
            <button form="briefForm" type="submit" class="px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all">
                Publish Brief
            </button>
        </div>
    </div>

    <form id="briefForm" action="{{ route('instructor.briefs.store') }}" method="POST" class="space-y-10">
        @csrf
        
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm space-y-8">
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Project Identity</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., Fullstack E-commerce Architecture" 
                    class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-xl font-bold text-slate-800 outline-none transition-all placeholder:text-slate-300">
                @error('title') <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Format</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="individual" class="peer sr-only" checked>
                            <div class="p-4 text-center rounded-2xl border-2 border-slate-50 bg-slate-50 font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all">
                                Individual
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="group" class="peer sr-only">
                            <div class="p-4 text-center rounded-2xl border-2 border-slate-50 bg-slate-50 font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all">
                                Group
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Target Sprint</label>
                    <div class="relative">
                        <select name="sprint_id" class="w-full px-8 py-4.5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all appearance-none">
                            @foreach($sprints as $sprint)
                                <option value="{{ $sprint->id }}">{{ $sprint->name }}</option>
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
                    <input type="date" name="start_date" value="{{ old('start_date') }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Deadline</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute -top-3 left-10 px-4 bg-[#f8fafc] text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] z-10">
                Project Content & Instructions
            </div>
            <div class="bg-white border-2 border-dashed border-slate-200 group-focus-within:border-indigo-500 group-focus-within:bg-white transition-all rounded-[3rem] overflow-hidden">
                <textarea name="content" rows="15" 
                    placeholder="Describe the professional context, technical requirements, and what you expect from the students..." 
                    class="focus:outline-none w-full p-12 bg-transparent border-none focus:ring-0 text-lg text-slate-600 leading-relaxed font-medium placeholder:text-slate-200 resize-none min-h-[500px]">{{ old('content') }}</textarea>
                
                <div class="bg-slate-50 px-12 py-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Markdown style supported</span>
                    <div class="flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
        filter: grayscale(1);
    }
    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }
</style>
@endsection