@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto">
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="md:col-span-2 bg-indigo-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-200">
            <div class="relative z-10">
                <h1 class="text-3xl font-black mb-2">Welcome back, {{ auth()->user()->firstName }}!</h1>
                <p class="text-indigo-100 font-medium">
                    You have {{ $totalLearners }} learners across {{ $classrooms->count() }} classrooms.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 h-64 w-64 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unassigned Learners</p>
                    <h2 class="text-4xl font-black text-slate-900">{{ $unassignedLearners->count() }}</h2>
                </div>
                @if($classrooms->isNotEmpty() && $unassignedLearners->isNotEmpty())
                <button onclick="openManageModal({{ $classrooms->first()->id }}, '{{ addslashes($classrooms->first()->name) }}')" 
                        class="h-10 w-10 bg-amber-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-amber-200 hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </button>
                @endif
            </div>
            <div class="mt-4 flex items-center gap-2 text-amber-500 font-bold text-xs">
                <span>Available to add to your groups</span>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Your Classrooms</h2>
            <p class="text-sm text-slate-500 font-medium">Add or remove learners from your assigned groups.</p>
        </div>
        
        @if($classrooms->isNotEmpty())
        <button type="button" onclick="openManageModal({{ $classrooms->first()->id }}, '{{ addslashes($classrooms->first()->name) }}')" 
                class="flex items-center gap-3 px-6 py-4 bg-slate-900 text-white rounded-2xl hover:bg-indigo-600 transition-all shadow-lg group">
            <span class="text-sm font-bold">Assign Learners</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classrooms as $class)
        <div class="group bg-white border border-slate-100 rounded-[2.5rem] p-8 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 relative">
            <div class="flex justify-between items-start mb-6">
                <div class="h-14 w-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                
                <button onclick="openManageModal({{ $class->id }}, '{{ addslashes($class->name) }}')" class="px-4 py-2 bg-slate-50 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">
                    Add Learners
                </button>
            </div>

            <h3 class="text-xl font-black text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $class->name }}</h3>
            <p class="text-sm text-slate-400 font-bold mb-6">{{ $class->learners_count }} Learners Currently Enrolled</p>

            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <a href="{{ route('instructor.classrooms.show', $class->id) }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-2">
                    View Learner List
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
            <p class="text-slate-400 font-bold text-lg">No assigned classrooms.</p>
            <p class="text-slate-400 text-sm">Wait for an administrator to assign you to a classroom.</p>
        </div>
        @endforelse
    </div>

    <div id="manageModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="closeManageModal()"></div>
        <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl relative z-10 p-10 overflow-hidden flex flex-col max-h-[90vh]">
            <div class="mb-6">
                <h3 id="modalClassTitle" class="text-2xl font-black text-slate-900 mb-1">Classroom Name</h3>
                <p class="text-sm text-slate-500 font-medium">Assign unlinked learners to this class.</p>
            </div>

            <form action="{{ route('instructor.learners.assign') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="mb-4 space-y-2" id="classSelectContainer">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Target Classroom</label>
                    <select name="classroom_id" id="modalClassId" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-3 mb-6 custom-scrollbar">
                    @forelse($unassignedLearners as $learner)
                    <label class="flex items-center p-4 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500 transition-all cursor-pointer group">
                        <input type="checkbox" name="learner_ids[]" value="{{ $learner->id }}" class="w-5 h-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-4">
                            <p class="text-sm font-black text-slate-900 leading-none group-hover:text-indigo-600">{{ $learner->firstName }} {{ $learner->lastName }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $learner->email }}</p>
                        </div>
                    </label>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-slate-400 font-bold text-sm">No unassigned learners available.</p>
                    </div>
                    @endforelse
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:bg-indigo-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed" 
                    @if($unassignedLearners->isEmpty()) disabled @endif>
                    Confirm Assignment
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('manageModal');
    const classTitle = document.getElementById('modalClassTitle');
    const classSelect = document.getElementById('modalClassId');

    function openManageModal(id, name) {
        classTitle.innerText = "Assign to: " + name;
        classSelect.value = id;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeManageModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.onkeydown = function(e) {
        if (e.key === "Escape") closeManageModal();
    };
</script>
@endsection