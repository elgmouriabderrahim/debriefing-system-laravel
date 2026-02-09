@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('instructor.dashboard') }}" class="h-12 w-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900">{{ $classroom->name }}</h1>
                <p class="text-slate-500 font-medium">Manage learners and view performance for this group.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Enrolled</p>
            <h2 class="text-4xl font-black text-slate-900">{{ $classroom->learners->count() }}</h2>
        </div>
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Promotion Year</p>
            <h2 class="text-4xl font-black text-slate-900">{{ $classroom->promotion_year ?? 'N/A' }}</h2>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Learner</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($classroom->learners as $learner)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-sm">
                                {{ substr($learner->firstName, 0, 1) }}{{ substr($learner->lastName, 0, 1) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $learner->firstName }} {{ $learner->lastName }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-slate-500 font-medium">{{ $learner->email }}</td>
                    <td class="px-8 py-6 text-right">
                        <button class="text-slate-400 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-8 py-12 text-center text-slate-400 font-medium">
                        No learners assigned to this classroom yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection