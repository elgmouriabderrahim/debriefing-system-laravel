@extends('layouts.main')
@section('title', 'Project Debriefings')

@section('content')
<div class="min-h-screen bg-[#FDFDFE] antialiased pb-20">
    <div class="max-w-[1250px] mx-auto px-8 pt-12">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-500 mb-2 block">Management Console</span>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Project Debriefings</h1>
                <p class="text-slate-500 mt-2 text-sm font-medium">Monitor student progress and evaluate project deliverables.</p>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-white border border-slate-100 px-6 py-3 rounded-2xl shadow-sm">
                    <span class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter">Total Projects</span>
                    <span class="text-xl font-black text-slate-900">{{ $briefs->count() }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-[2rem] shadow-xl shadow-slate-200/40 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-50">
                        <th class="px-8 py-6 text-[11px] font-black uppercase tracking-widest text-slate-400">Project Details</th>
                        <th class="px-8 py-6 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">Type</th>
                        <th class="px-8 py-6 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">Submissions</th>
                        <th class="px-8 py-6 text-[11px] font-black uppercase tracking-widest text-slate-400 text-center">Creation Date</th>
                        <th class="px-8 py-6 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($briefs as $brief)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $brief->title }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Ref: #PROJ-{{ $brief->id }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <span class="inline-flex px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-tight group-hover:bg-indigo-100 group-hover:text-indigo-700 transition-colors">
                                {{ $brief->type }}
                            </span>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex items-center gap-2">
                                <span class="text-sm font-black text-slate-900">{{ $brief->unique_submissions_count }}</span>
                                <span class="text-[10px] font-bold text-slate-400">Students</span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-bold text-slate-500">{{ $brief->created_at->format('M d, Y') }}</span>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('instructor.debriefings.show', $brief->id) }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl text-[11px] font-black uppercase tracking-wider hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-200 transition-all">
                                <span>Review</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-16 w-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">No Active Briefs Found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-between items-center px-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Displaying All Projects</p>
        </div>
    </div>
</div>
@endsection