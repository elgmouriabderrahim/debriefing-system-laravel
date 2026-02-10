@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto pb-20">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Project Briefs</h1>
            <p class="text-slate-500 font-medium">Manage and assign learning scenarios to your sprints.</p>
        </div>
        <a href="{{ route('instructor.briefs.create') }}" 
           class="inline-flex items-center gap-3 bg-slate-900 hover:bg-emerald-600 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-xl shadow-slate-200 group hover:-translate-y-1">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Create New Brief</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($briefs as $brief)
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 hover:shadow-xl transition-all group relative overflow-hidden flex flex-col h-full">
            <div class="absolute -right-4 -top-4 h-24 w-24 bg-indigo-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

            <div class="flex justify-between items-start mb-6 relative">
                <span class="px-4 py-1.5 {{ $brief->type === 'individual' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} rounded-full text-[10px] font-black uppercase tracking-widest border border-current/10">
                    {{ $brief->type }}
                </span>
                <span class="text-slate-400 text-[11px] font-bold">
                    {{ \Carbon\Carbon::parse($brief->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($brief->end_date)->format('M d, Y') }}
                </span>
            </div>

            <div class="flex-grow">
                <h3 class="text-2xl font-black text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $brief->title }}</h3>
                <p class="text-slate-500 text-sm line-clamp-2 mb-4 font-medium leading-relaxed italic">"{{ Str::limit(strip_tags($brief->content), 120) }}"</p>

                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($brief->competences as $comp)
                        <span class="px-2.5 py-1 bg-slate-50 text-slate-500 text-[9px] font-black rounded-lg border border-slate-100 uppercase tracking-tighter hover:bg-indigo-600 hover:text-white transition-colors cursor-default">
                            {{ $comp->code }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-8 mb-8 pt-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Active Sprint</p>
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 bg-indigo-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-bold text-slate-700">{{ $brief->sprint->name ?? 'Unassigned' }}</span>
                    </div>
                </div>
                <div class="border-l border-slate-100 pl-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Deliverables</p>
                    <span class="text-sm font-bold text-slate-700">{{ $brief->livrables_count }} Total</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <a href="{{ route('instructor.briefs.show', $brief->id) }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors inline-flex items-center gap-2">
                    View Submissions
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </a>
                
                <div class="flex items-center gap-1">
                    <a href="{{ route('instructor.briefs.edit', $brief->id) }}" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Edit Brief">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>

                    <form action="{{ route('instructor.briefs.destroy', $brief->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="delete-btn p-2.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Delete Project">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
            <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-slate-400 font-bold text-lg">No briefs created yet.</p>
            <p class="text-slate-400 text-sm">Click the button above to start your first project.</p>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Delete this project?',
                text: "All student submissions for this brief will also be removed!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f172a', // slate-900
                cancelButtonColor: '#f1f5f9', // slate-100
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl',
                    confirmButton: 'px-6 py-3 rounded-xl font-black uppercase text-[10px] tracking-widest',
                    cancelButton: 'px-6 py-3 rounded-xl font-black uppercase text-[10px] tracking-widest text-slate-500'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection