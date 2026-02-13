@extends('layouts.main')
@section('title','Debriefings-system | Dashboard')
@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-12">
    
    {{-- Header Section --}}
    <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-xl font-black shadow-lg shadow-blue-100">
                {{ substr($user->classroom?->name ?? 'C', 0, 1) }}
            </div>
            <div>
                <h1 class="text-lg font-black text-slate-900 leading-none">{{ $user->classroom?->name ?? 'Unassigned' }}</h1>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-wider mt-1">
                    {{ $user->classroom?->promotion_year ?? '2026' }} • {{ $user->classroom?->learners?->count() ?? 0 }} Students
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-slate-50 pl-4 pr-2 py-2 rounded-2xl border border-slate-100">
            @php $instructor = $user->classroom?->instructors?->first(); @endphp
            <div class="text-right">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Instructor</p>
                <p class="text-xs font-bold text-slate-800 leading-none">
                    {{ $instructor?->first_name ?? 'Lead' }}
                </p>
            </div>
            <div class="h-8 w-8 bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($instructor?->first_name ?? 'I') }}&background=0f172a&color=fff" alt="Instructor">
            </div>
        </div>
    </div>

    {{-- Legend / Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach([
            ['L1', 'imiter', 'blue', 'Reproduce tasks exactly as demonstrated.'],
            ['L2', 's_adapter', 'indigo', 'Adjust skills to similar contexts.'],
            ['L3', 'transposer', 'emerald', 'Apply concepts to new situations.']
        ] as [$code, $label, $color, $desc])
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 transition-all">
            <div class="h-10 w-10 rounded-xl bg-{{$color}}-50 text-{{$color}}-600 flex items-center justify-center font-black text-xs shrink-0">
                {{ $code }}
            </div>
            <div>
                <h4 class="text-{{$color}}-600 font-black text-[10px] uppercase tracking-widest">{{ str_replace('_', ' ', $label) }}</h4>
                <p class="text-[11px] text-slate-400 leading-tight line-clamp-1">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Matrix --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">My Competence Matrix</h3>
            <span class="text-[10px] font-bold text-slate-400 italic">Live Updates</span>
        </div>
        
        <div class="divide-y divide-slate-50">
            @forelse($competenceProgress as $item)
            @php 
                $currentLevel = strtolower($item['level']); // Safety check to ensure it's lowercase
            @endphp
            <div class="px-6 py-3 group hover:bg-slate-50/50 transition-all">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
                    <div class="lg:col-span-4 flex items-center gap-3">
                        <span class="text-[10px] font-black text-slate-300 w-8">{{ $item['info']?->code ?? '??' }}</span>
                        <h4 class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition-colors truncate">
                            {{ $item['info']?->label ?? 'Competence' }}
                        </h4>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="flex items-center gap-3">
                            {{-- PROGRESS BAR LOGIC - ALL LOWERCASE --}}
                            <div class="flex-1 h-2 bg-slate-100 rounded-full flex p-0.5 gap-1">
                                {{-- Bar 1: Blue if level is at least imiter --}}
                                <div class="h-full rounded-full flex-1 {{ in_array($currentLevel, ['imiter', 's_adapter', 'transposer']) ? 'bg-blue-500' : 'bg-slate-200' }}"></div>
                                
                                {{-- Bar 2: Indigo if level is at least s_adapter --}}
                                <div class="h-full rounded-full flex-1 {{ in_array($currentLevel, ['s_adapter', 'transposer']) ? 'bg-indigo-500' : 'bg-slate-200' }}"></div>
                                
                                {{-- Bar 3: Emerald if level is exactly transposer --}}
                                <div class="h-full rounded-full flex-1 {{ $currentLevel == 'transposer' ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                            </div>

                            <span class="text-[9px] font-black text-slate-400 uppercase w-20 text-right">
                                {{ str_replace('_', ' ', $currentLevel ?? 'N/A') }}
                            </span>
                        </div>
                    </div>

                    <div class="lg:col-span-3 text-right">
                        <p class="text-[10px] text-slate-400 italic truncate">
                            {{ $item['comment'] ?? 'Pending Evaluation...' }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-slate-400 italic text-xs">No competences assigned yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection