@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto pb-20">
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center gap-6">
            <a href="{{ route('instructor.dashboard') }}" class="h-14 w-14 bg-white border border-slate-100 rounded-[1.25rem] flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">{{ $classroom->name }}</h1>
                <p class="text-slate-500 font-medium mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Manage Learner Assignments
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Currently Assigned</p>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $classroom->learners->count() }}</h2>
        </div>
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Cohort Year</p>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $classroom->promotion_year ?? 'N/A' }}</h2>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm">
        <div class="px-10 py-8 border-b border-slate-50">
            <h3 class="font-black text-slate-900 text-lg uppercase tracking-tight">Active Assignments</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Learner</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Address</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($classroom->learners as $learner)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-slate-100 text-slate-900 rounded-[1rem] flex items-center justify-center font-black text-sm border border-slate-200 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                    {{ substr($learner->first_name, 0, 1) }}{{ substr($learner->last_name, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $learner->first_name }} {{ $learner->last_name }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-slate-500 font-bold text-sm lowercase">{{ $learner->email }}</td>
                        <td class="px-10 py-6 text-right">
                            <button type="button" 
                                    onclick="triggerUnassign('{{ $learner->id }}', '{{ $learner->first_name }} {{ $learner->last_name }}')"
                                    class="p-3 bg-white border border-slate-100 hover:border-rose-500 text-slate-400 hover:text-rose-600 rounded-xl transition-all shadow-sm group/btn">
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
                            </button>

                            <form id="unassign-form-{{ $learner->id }}" action="{{ route('instructor.classrooms.unassign', [$classroom->id, $learner->id]) }}" method="POST" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-10 py-20 text-center">
                            <p class="text-slate-400 font-bold italic">No learners currently assigned to this classroom.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConfirm()"></div>
    <div class="bg-white max-w-sm w-full rounded-[2.5rem] p-10 relative z-10 text-center shadow-2xl border border-white">
        <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
        </div>
        <h4 class="text-2xl font-black text-slate-900 mb-2">Unassign Learner?</h4>
        <p class="text-slate-500 text-sm mb-10 leading-relaxed">This will remove <span id="targetName" class="font-bold text-slate-900"></span> from the classroom registry.</p>
        <div class="flex gap-4">
            <button onclick="closeConfirm()" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">Keep</button>
            <button id="confirmBtn" class="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-rose-200">Unassign</button>
        </div>
    </div>
</div>

<script>
    let currentId = null;
    const confirmModal = document.getElementById('confirmModal');

    function triggerUnassign(id, name) {
        currentId = id;
        document.getElementById('targetName').innerText = name;
        confirmModal.classList.remove('hidden');
    }

    function closeConfirm() {
        confirmModal.classList.add('hidden');
        currentId = null;
    }

    document.getElementById('confirmBtn').addEventListener('click', () => {
        if(currentId) document.getElementById(`unassign-form-${currentId}`).submit();
    });

    window.onkeydown = (e) => { if(e.key === "Escape") closeConfirm(); };
</script>
@endsection