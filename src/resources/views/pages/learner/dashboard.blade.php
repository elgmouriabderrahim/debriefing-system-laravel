@extends('layouts.main')
@section('title','Debriefings-system | Dashboard')
@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12">
    
    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-6">
            <div class="h-20 w-20 bg-blue-600 rounded-3xl flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-blue-200">
                {{ substr($user->classroom->name ?? 'C', 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900">{{ $user->classroom->name ?? 'General Class' }}</h1>
                <p class="text-slate-500 font-bold text-sm uppercase tracking-wider">
                    {{ $user->classroom->promotion_year ?? '2026' }} • {{ $user->classroom->learners->count() }} Students
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-slate-50 px-6 py-4 rounded-3xl border border-slate-100">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Instructor</p>
                <p class="text-sm font-black text-slate-800">
                    {{ $user->classroom->instructors->first()->first_name ?? 'Lead' }} {{ $user->classroom->instructors->first()->last_name ?? 'Trainer' }}
                </p>
            </div>
            <div class="h-12 w-12 bg-slate-200 rounded-2xl overflow-hidden border-2 border-white shadow-sm">
                <img src="https://ui-avatars.com/api/?name={{ $user->classroom->instructors->first()->first_name ?? 'I' }}&background=0f172a&color=fff" alt="Instructor">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border-l-4 border-blue-500 shadow-sm">
            <h4 class="text-blue-600 font-black text-xs uppercase tracking-widest mb-2">Level 01: IMITER</h4>
            <p class="text-xs text-slate-500 leading-relaxed">Reproduce a task by following a model or methodology exactly as demonstrated.</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border-l-4 border-indigo-500 shadow-sm">
            <h4 class="text-indigo-600 font-black text-xs uppercase tracking-widest mb-2">Level 02: S_ADAPTER</h4>
            <p class="text-xs text-slate-500 leading-relaxed">Adjust your skills to solve problems in similar but slightly different contexts.</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border-l-4 border-emerald-500 shadow-sm">
            <h4 class="text-emerald-600 font-black text-xs uppercase tracking-widest mb-2">Level 03: TRANSPOSER</h4>
            <p class="text-xs text-slate-500 leading-relaxed">Apply concepts to entirely new and complex situations with full autonomy.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <h3 class="text-lg font-black text-slate-900 uppercase tracking-tighter italic">My Competence Matrix</h3>
        </div>
        
        <div class="divide-y divide-slate-50">
            @forelse($competenceProgress as $item)
            <div class="p-8 group hover:bg-slate-50/50 transition-all">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    <div class="lg:col-span-4 flex items-center gap-4">
                        <span class="text-xs font-black text-slate-300">{{ $item['info']->code }}</span>
                        <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $item['info']->label }}</h4>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="flex items-center gap-3">
                            <div class="flex-1 h-3 bg-slate-100 rounded-full flex p-0.5 gap-1">
                                <div class="h-full rounded-full flex-1 {{ in_array($item['level'], ['IMITER', 'S_ADAPTER', 'TRANSPOSER']) ? 'bg-blue-500' : 'bg-slate-200' }}"></div>
                                <div class="h-full rounded-full flex-1 {{ in_array($item['level'], ['S_ADAPTER', 'TRANSPOSER']) ? 'bg-indigo-500' : 'bg-slate-200' }}"></div>
                                <div class="h-full rounded-full flex-1 {{ $item['level'] == 'TRANSPOSER' ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 uppercase w-24 text-right">
                                {{ str_replace('_', ' ', $item['level']) }}
                            </span>
                        </div>
                    </div>

                    <div class="lg:col-span-3 text-right">
                        @if($item['comment'])
                            <p class="text-[11px] text-slate-400 italic line-clamp-1 group-hover:line-clamp-none">"{{ $item['comment'] }}"</p>
                        @else
                            <span class="text-[10px] font-bold text-slate-300 uppercase italic">Pending Evaluation</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-20 text-center text-slate-400 italic">No competences assigned yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection