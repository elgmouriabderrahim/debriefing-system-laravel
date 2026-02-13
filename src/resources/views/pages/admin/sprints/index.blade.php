@extends('layouts.main')
@section('title','Debriefings-system | sprints')
@section('content')
<div class="max-w-[1400px] mx-auto pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Sprint Pipeline</h1>
            <p class="text-slate-500 font-medium mt-2 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>
                Define curriculum timeline and sequences
            </p>
        </div>
        
        <button type="button" id="AddNewSprint"
                class="inline-flex items-center gap-3 bg-slate-900 hover:bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-xl shadow-slate-200 group hover:-translate-y-1">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            New Sprint
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($sprints as $sprint)
        <div class="group bg-white border border-slate-100 rounded-[2.5rem] p-8 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-500/30 transition-all duration-500 relative flex flex-col h-full">
            
            <div class="absolute right-6 top-6 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                <button type="button" 
                        onclick="initEdit({ 
                            id: '{{ $sprint->id }}', 
                            name: '{{ addslashes($sprint->name) }}', 
                            duration_days: '{{ $sprint->duration_days }}',
                            order: '{{ $sprint->order }}'
                        })" 
                        class="p-3 bg-white border border-slate-100 hover:border-indigo-500 text-slate-400 hover:text-indigo-600 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
                <button type="button" onclick="triggerDelete('{{ $sprint->id }}', '{{ $sprint->name }}')" 
                        class="p-3 bg-white border border-slate-100 hover:border-rose-500 text-slate-400 hover:text-rose-600 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                <form id="delete-form-{{ $sprint->id }}" action="{{ route('admin.sprints.destroy', $sprint->id) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            </div>

            <div class="flex items-center gap-5 mb-8">
                <div class="h-16 w-16 shrink-0 bg-slate-900 text-white rounded-[1.5rem] flex items-center justify-center font-black text-2xl group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-500 shadow-lg shadow-slate-200">
                    {{ $sprint->order }}
                </div>
                <div class="overflow-hidden">
                    <h3 class="text-xl font-black text-slate-900 truncate group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $sprint->name }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Sprint Sequence</p>
                </div>
            </div>

            <div class="space-y-4 mt-auto">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 text-[11px] font-bold rounded-xl border border-indigo-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $sprint->duration_days }} Days
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-600 text-[11px] font-bold rounded-xl border border-slate-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Active Briefs
                    </span>
                </div>

                <div class="pt-5 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pipeline Status</p>
                    <span class="text-[10px] font-black text-emerald-500 uppercase italic">Operational</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 border-2 border-dashed border-slate-100 rounded-[3rem] text-center">
            <p class="text-slate-400 font-bold italic text-lg">No Sprints in the pipeline.</p>
        </div>
        @endforelse
    </div>

    <div id="sprintModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="closeModal()"></div>
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden border border-white">
            <div class="p-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 tracking-tight">Design Sprint</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="sprintForm" method="POST" class="space-y-6">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sprint Title</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"  
                            class="w-full px-5 py-4 bg-slate-50 border-2 {{ $errors->has('name') ? 'border-rose-500' : 'border-transparent' }} focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                        @error('name')
                            <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Duration (Days)</label>
                            <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days') }}"  
                                class="w-full px-5 py-4 bg-slate-50 border-2 {{ $errors->has('duration_days') ? 'border-rose-500' : 'border-transparent' }} focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                            @error('duration_days')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Order Index</label>
                            <input type="number" name="order" id="order" value="{{ old('order') }}" 
                                class="w-full px-5 py-4 bg-slate-50 border-2 {{ $errors->has('order') ? 'border-rose-500' : 'border-transparent' }} focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                            @error('order')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 transition-all active:scale-[0.98]">
                            Confirm Sprint
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConfirm()"></div>
        <div class="bg-white max-w-sm w-full rounded-[2.5rem] p-8 relative z-10 text-center shadow-2xl border border-white">
            <h4 class="text-2xl font-black text-slate-900 mb-2">Delete Sprint?</h4>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Remove <span id="targetName" class="font-bold text-slate-900"></span> from the pipeline?</p>
            <div class="flex gap-3">
                <button onclick="closeConfirm()" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">Cancel</button>
                <button id="confirmDeleteBtn" class="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-rose-200">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('sprintModal');
    const confirmModal = document.getElementById('confirmModal');
    const form = document.getElementById('sprintForm');
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

    document.getElementById('AddNewSprint').addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'New Sprint';
        form.action = "{{ route('admin.sprints.store') }}";
        document.getElementById('methodContainer').innerHTML = '';
        // Set default order index
        document.getElementById('order').value = '{{ $sprints->count() + 1 }}';
        openModal();
    });

    function initEdit(sprint) {
        clearValidationErrors();
        document.getElementById('modalTitle').innerText = 'Update Sprint';
        form.action = `/admin/sprints/${sprint.id}`;
        document.getElementById('methodContainer').innerHTML = '@method("PUT")';
        
        document.getElementById('name').value = sprint.name;
        document.getElementById('duration_days').value = sprint.duration_days;
        document.getElementById('order').value = sprint.order;
        
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

    window.onkeydown = (e) => { 
        if(e.key === "Escape") { closeModal(); closeConfirm(); } 
    };

    function clearValidationErrors() {
        const errorMessages = document.querySelectorAll('.text-rose-500.font-bold');
        errorMessages.forEach(msg => msg.remove());

        const errorInputs = document.querySelectorAll('.border-rose-500');
        errorInputs.forEach(input => {
            input.classList.remove('border-rose-500');
            input.classList.add('border-transparent');
        });
    }

    @if ($errors->any())
        window.onload = () => openModal();
    @endif
</script>
@endsection