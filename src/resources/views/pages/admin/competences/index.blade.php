@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Competency Framework</h1>
            <p class="text-slate-500 font-medium mt-2 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                Manage technical labels and system codes
            </p>
        </div>
        
        <button type="button" id="AddNewCompetence"
                class="inline-flex items-center gap-3 bg-slate-900 hover:bg-emerald-600 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-xl shadow-slate-200 group hover:-translate-y-1">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add Competence
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($competences as $competence)
        <div class="group bg-white border border-slate-100 rounded-[2.5rem] p-8 hover:shadow-2xl hover:shadow-emerald-500/10 hover:border-emerald-500/30 transition-all duration-500 relative flex flex-col h-full">
            
            <div class="absolute right-6 top-6 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                <button type="button" 
                        onclick="initEdit({ 
                            id: '{{ $competence->id }}', 
                            label: '{{ addslashes($competence->label) }}', 
                            code: '{{ addslashes($competence->code) }}'
                        })" 
                        class="p-3 bg-white border border-slate-100 hover:border-emerald-500 text-slate-400 hover:text-emerald-600 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
                <button type="button" onclick="triggerDelete('{{ $competence->id }}', '{{ $competence->label }}')" 
                        class="p-3 bg-white border border-slate-100 hover:border-rose-500 text-slate-400 hover:text-rose-600 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                <form id="delete-form-{{ $competence->id }}" action="{{ route('admin.competences.destroy', $competence->id) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            </div>

            <div class="flex items-center gap-5 mb-8">
                <div class="h-16 w-16 shrink-0 bg-emerald-50 text-emerald-600 rounded-[1.5rem] flex items-center justify-center font-black text-xs border border-emerald-100 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 shadow-sm uppercase px-2 text-center break-all">
                    {{ $competence->code }}
                </div>
                <div class="overflow-hidden">
                    <h3 class="text-xl font-black text-slate-900 truncate group-hover:text-emerald-600 transition-colors tracking-tight">{{ $competence->label }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Technical Asset</p>
                </div>
            </div>

            <div class="space-y-4 mt-auto">
                <div class="p-4 bg-slate-50 rounded-2xl group-hover:bg-slate-100 transition-colors">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Internal Reference Code</p>
                    <code class="text-xs font-mono font-bold text-emerald-700 bg-white px-2 py-1 rounded-md border border-slate-200">
                        {{ $competence->code }}
                    </code>
                </div>

                <div class="pt-5 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Asset Status</p>
                    <span class="text-[10px] font-black text-emerald-500 uppercase italic">Verified</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 border-2 border-dashed border-slate-100 rounded-[3rem] text-center">
            <p class="text-slate-400 font-bold italic text-lg">No competencies defined yet.</p>
        </div>
        @endforelse
    </div>

    <div id="competenceModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="closeModal()"></div>
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden border border-white">
            <div class="p-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 tracking-tight">Competence Settings</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="competenceForm" method="POST" class="space-y-6">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Competence Label</label>
                        <input type="text" name="label" id="label" required placeholder="e.g. Frontend Development" 
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-emerald-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Reference Code</label>
                        <input type="text" name="code" id="code" required placeholder="e.g. FE-001" 
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-emerald-500 rounded-2xl font-bold font-mono text-emerald-700 outline-none transition-all">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl shadow-slate-200 hover:bg-emerald-600 transition-all active:scale-[0.98]">
                            Save Competence
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConfirm()"></div>
        <div class="bg-white max-w-sm w-full rounded-[2.5rem] p-8 relative z-10 text-center shadow-2xl border border-white">
            <h4 class="text-2xl font-black text-slate-900 mb-2">Delete Competence?</h4>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Remove <span id="targetName" class="font-bold text-slate-900"></span>? This cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeConfirm()" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">Cancel</button>
                <button id="confirmDeleteBtn" class="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-rose-200">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('competenceModal');
    const confirmModal = document.getElementById('confirmModal');
    const form = document.getElementById('competenceForm');
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

    document.getElementById('AddNewCompetence').addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'New Competence';
        form.action = "{{ route('admin.competences.store') }}";
        document.getElementById('methodContainer').innerHTML = '';
        openModal();
    });

    function initEdit(competence) {
        document.getElementById('modalTitle').innerText = 'Edit Competence';
        form.action = `/admin/competences/${competence.id}`;
        document.getElementById('methodContainer').innerHTML = '@method("PUT")';
        
        document.getElementById('label').value = competence.label;
        document.getElementById('code').value = competence.code;
        
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
</script>
@endsection