@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Classroom Inventory</h1>
            <p class="text-slate-500 font-medium mt-2 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-blue-500"></span>
                Active Educational Cohorts
            </p>
        </div>
        
        <button type="button" id="AddNewClassroom"
                class="inline-flex items-center gap-3 bg-slate-900 hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-xl shadow-slate-200 group hover:-translate-y-1">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add Classroom
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($classrooms as $classroom)
        <div class="group bg-white border border-slate-100 rounded-[2.5rem] p-8 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-500/30 transition-all duration-500 relative flex flex-col h-full">
            
            <div class="absolute right-6 top-6 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                <button type="button" 
                        onclick="initEdit({ 
                            id: '{{ $classroom->id }}', 
                            name: '{{ addslashes($classroom->name) }}', 
                            promotion_year: '{{ $classroom->promotion_year }}' 
                        })" 
                        class="p-3 bg-white border border-slate-100 hover:border-blue-500 text-slate-400 hover:text-blue-600 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
                <button type="button" onclick="triggerDelete('{{ $classroom->id }}', '{{ $classroom->name }}')" 
                        class="p-3 bg-white border border-slate-100 hover:border-rose-500 text-slate-400 hover:text-rose-600 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                <form id="delete-form-{{ $classroom->id }}" action="{{ route('admin.classrooms.destroy', $classroom->id) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            </div>

            <div class="flex items-center gap-5 mb-8">
                <div class="h-16 w-16 shrink-0 bg-gradient-to-br from-slate-50 to-slate-100 text-slate-900 rounded-[1.5rem] flex items-center justify-center font-black text-2xl border border-slate-200 group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white group-hover:scale-110 transition-all duration-500 shadow-sm uppercase">
                    {{ substr($classroom->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <h3 class="text-xl font-black text-slate-900 truncate group-hover:text-blue-600 transition-colors uppercase tracking-tight">{{ $classroom->name }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">PROMOTION {{ $classroom->promotion_year }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4 mt-auto">
                <div class="p-4 bg-slate-50 rounded-2xl group-hover:bg-slate-100 transition-colors">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Supervising Instructors</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($classroom->instructors as $instructor)
                            <span class="inline-flex items-center px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-black rounded-lg shadow-sm">
                                {{ $instructor->first_name }}
                            </span>
                        @empty
                            <span class="text-[10px] text-slate-400 font-bold italic text-opacity-50">Unassigned</span>
                        @endforelse
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-4 bg-slate-50 rounded-2xl group-hover:bg-slate-100 transition-colors">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Status</p>
                        <p class="text-xs font-black text-emerald-600 uppercase">Live</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl group-hover:bg-slate-100 transition-colors text-right">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Learners</p>
                        <p class="text-xs font-black text-slate-700">{{ $classroom->learners_count ?? 0 }} Members</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 border-2 border-dashed border-slate-100 rounded-[3rem] text-center">
            <p class="text-slate-400 font-bold italic text-lg">Inventory Empty. Deploy a new cohort.</p>
        </div>
        @endforelse
    </div>

    <div id="classroomModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="closeModal()"></div>
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden border border-white">
            <div class="p-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 tracking-tight">Classroom Settings</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="classroomForm" method="POST" class="space-y-6">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Classroom Name</label>
                        <input type="text" name="name" id="name" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Promotion Year</label>
                        <input type="number" name="promotion_year" id="promotion_year" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl shadow-slate-200 hover:bg-blue-600 transition-all active:scale-[0.98]">
                            Save Classroom
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConfirm()"></div>
        <div class="bg-white max-w-sm w-full rounded-[2.5rem] p-8 relative z-10 text-center shadow-2xl border border-white">
            <h4 class="text-2xl font-black text-slate-900 mb-2">Archive Class?</h4>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Remove <span id="targetName" class="font-bold text-slate-900"></span> from active inventory?</p>
            <div class="flex gap-3">
                <button onclick="closeConfirm()" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">Cancel</button>
                <button id="confirmDeleteBtn" class="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-rose-200">Archive</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('classroomModal');
    const confirmModal = document.getElementById('confirmModal');
    const form = document.getElementById('classroomForm');
    let currentDeleteId = null;

    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        form.reset();
    }

    document.getElementById('AddNewClassroom').addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'New Classroom';
        form.action = "{{ route('admin.classrooms.store') }}";
        document.getElementById('methodContainer').innerHTML = '';
        openModal();
    });

    function initEdit(classroom) {
        document.getElementById('modalTitle').innerText = 'Edit Classroom';
        form.action = `/admin/classrooms/${classroom.id}`;
        document.getElementById('methodContainer').innerHTML = '@method("PUT")';
        
        document.getElementById('name').value = classroom.name;
        document.getElementById('promotion_year').value = classroom.promotion_year;
        
        openModal();
    }

    function triggerDelete(id, name) {
        currentDeleteId = id;
        document.getElementById('targetName').innerText = name;
        confirmModal.classList.remove('hidden');
    }

    function closeConfirm() {
        confirmModal.classList.add('hidden');
        currentDeleteId = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if(currentDeleteId) document.getElementById(`delete-form-${currentDeleteId}`).submit();
    });
</script>
@endsection