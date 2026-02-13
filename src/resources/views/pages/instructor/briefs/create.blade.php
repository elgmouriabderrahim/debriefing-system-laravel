@extends('layouts.main')
@section('title','Debriefings-system | Create brief')
@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="flex items-end justify-between mb-12">
        <div class="flex items-start gap-5">
            <a href="{{ route('instructor.briefs.index') }}" 
               class="h-12 w-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-all group shadow-sm">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-[10px] font-black text-indigo-600 uppercase tracking-widest">Editor</span>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Draft New Brief</h1>
                </div>
                <p class="text-slate-500 font-medium mt-2 italic text-sm">Design a new learning scenario for your students.</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('instructor.briefs.index') }}" 
               class="text-sm font-bold text-slate-400 hover:text-rose-500 transition-all">Discard</a>
            <button form="briefForm" type="submit" 
                    class="px-8 py-3 bg-slate-900 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-[#050] transition-all shadow-lg shadow-slate-200">
                Create Brief
            </button>
        </div>
    </div>

    <form id="briefForm" action="{{ route('instructor.briefs.store') }}" method="POST" class="space-y-10">
        @csrf
        
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm space-y-10">
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Project Identity</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., Fullstack E-commerce Architecture" 
                    class="w-full px-8 py-5 bg-slate-50 border-2 {{ $errors->has('title') ? 'border-rose-400' : 'border-transparent' }} focus:border-indigo-500 focus:bg-white rounded-2xl text-xl font-bold text-slate-800 outline-none transition-all">
                @error('title') <p class="text-rose-500 text-[10px] font-black uppercase mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-4 p-6 rounded-[2rem] {{ $errors->has('competences') ? 'bg-rose-50/30 border-2 border-dashed border-rose-200' : '' }}">
                <div class="flex justify-between items-end ml-1">
                    <div class="flex items-center gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Target Competencies</label>
                        <span class="text-[9px] font-black px-1.5 py-0.5 bg-slate-100 text-slate-400 rounded-md uppercase">At least one required</span>
                    </div>
                    @error('competences') 
                        <p class="text-rose-500 text-[10px] font-black uppercase flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($competences as $competence)
                    @php 
                        $isChecked = is_array(old('competences')) && isset(old('competences')[$competence->id]['id']); 
                    @endphp
                    <div class="group relative competence-row">
                        <input type="checkbox" name="competences[{{ $competence->id }}][id]" value="{{ $competence->id }}" 
                            id="comp_{{ $competence->id }}" class="peer sr-only competence-checkbox" {{ $isChecked ? 'checked' : '' }}>
                        
                        <div class="flex items-center gap-4 px-6 py-4 rounded-[2rem] border-2 border-slate-50 bg-slate-50 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 group-hover:border-slate-200">
                            <label for="comp_{{ $competence->id }}" class="flex-1 cursor-pointer">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter block mb-1 peer-checked:text-emerald-600">{{ $competence->code }}</span>
                                <p class="text-sm font-bold text-slate-700 leading-tight">{{ $competence->label }}</p>
                            </label>

                            <div class="flex flex-col gap-1.5 items-end">
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Goal</span>
                                <select name="competences[{{ $competence->id }}][level]" 
                                    class="competence-level bg-white border border-slate-200 rounded-xl px-3 py-2 text-[10px] font-black text-slate-700 outline-none focus:border-emerald-500 transition-all disabled:bg-slate-100 disabled:text-slate-300">
                                    <option value="imiter" {{ old("competences.$competence->id.level") == 'imiter' ? 'selected' : '' }}>Imiter</option>
                                    <option value="s_adapter" {{ old("competences.$competence->id.level") == 's_adapter' ? 'selected' : '' }}>S'adapter</option>
                                    <option value="transposer" {{ old("competences.$competence->id.level") == 'transposer' ? 'selected' : '' }}>Transposer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Other Fields --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Format</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(['individual', 'group'] as $type)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="{{ $type }}" class="peer sr-only" {{ old('type', 'individual') == $type ? 'checked' : '' }}>
                            <div class="p-4 text-center rounded-2xl border-2 border-slate-50 bg-slate-50 font-black text-[10px] uppercase tracking-widest text-slate-400 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all">
                                {{ $type }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('type') <p class="text-rose-500 text-[10px] font-black uppercase ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Target Sprint</label>
                    <div class="relative">
                        <select name="sprint_id" class="w-full px-8 py-4.5 bg-slate-50 border-2 {{ $errors->has('sprint_id') ? 'border-rose-400' : 'border-transparent' }} focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all appearance-none">
                            <option value="">Select a sprint...</option>
                            @foreach($sprints as $sprint)
                                <option value="{{ $sprint->id }}" {{ old('sprint_id') == $sprint->id ? 'selected' : '' }}>{{ $sprint->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('sprint_id') <p class="text-rose-500 text-[10px] font-black uppercase ml-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 {{ $errors->has('start_date') ? 'border-rose-400' : 'border-transparent' }} focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    @error('start_date') <p class="text-rose-500 text-[10px] font-black uppercase mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Deadline</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 {{ $errors->has('end_date') ? 'border-rose-400' : 'border-transparent' }} focus:border-indigo-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    @error('end_date') <p class="text-rose-500 text-[10px] font-black uppercase mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="relative group">
            <div class="bg-white border-2 border-dashed {{ $errors->has('content') ? 'border-rose-300 bg-rose-50/20' : 'border-slate-200' }} rounded-[3rem] overflow-hidden">
                <textarea name="content" rows="12" placeholder="Describe the professional context..." 
                    class="focus:outline-none w-full p-12 bg-transparent border-none focus:ring-0 text-lg text-slate-600 font-medium min-h-[400px]">{{ old('content') }}</textarea>
                @error('content') <p class="text-rose-500 text-[10px] font-black uppercase pb-6 px-12">{{ $message }}</p> @enderror
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.competence-row');

        rows.forEach(row => {
            const checkbox = row.querySelector('.competence-checkbox');
            const select = row.querySelector('.competence-level');

            const updateState = () => {
                select.disabled = !checkbox.checked;
                if(select.disabled) {
                    select.classList.add('opacity-40');
                } else {
                    select.classList.remove('opacity-40');
                }
            };

            checkbox.addEventListener('change', updateState);
            updateState();
        });
    });
</script>
@endsection