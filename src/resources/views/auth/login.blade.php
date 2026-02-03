@extends('layouts.auth')

@section('content')
<div class="flex min-h-screen flex-col lg:flex-row bg-white">
    
    <div class="hidden lg:flex lg:w-[38%] bg-[#0A0A0B] p-12 flex-col justify-between relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="none" stroke="white" stroke-width="0.2" />
            </svg>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-xl">
                    <span class="text-black font-black text-sm">YC</span>
                </div>
                <span class="uppercase tracking-[0.3em] text-[10px] font-bold text-white/60">YouCode</span>
            </div>
        </div>

        <div class="relative z-10">
            <h1 class="text-4xl font-bold text-white tracking-tighter leading-tight">
                Debriefing <br> <span class="text-indigo-500">System.</span>
            </h1>
            <p class="mt-4 text-slate-500 text-sm font-medium leading-relaxed max-w-xs">
                Precision tracking for technical competences and student progress.
            </p>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-2 text-slate-600 text-[9px] font-bold uppercase tracking-widest">
                <div class="w-1 h-1 bg-indigo-500 rounded-full"></div>
                <span>Secured Institutional Gateway</span>
            </div>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center p-6 bg-[#F9FAFB]">
        <div class="w-full max-w-[380px] bg-white p-8 lg:p-10 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100">
            
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Log In</h2>
                <p class="text-slate-400 mt-2 text-sm font-medium">Access your YouCode account.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="relative group">
                    <label for="email" class="block text-sm font-bold">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full border-b border-slate-200 @error('email') border-red-500 @else focus:border-indigo-600 @enderror py-2 bg-transparent text-slate-900 outline-none transition-all text-base font-medium placeholder-slate-200"
                        placeholder="username@youcode.ma" id="email">
                    
                    @error('email')
                        <p class="mt-1.5 text-[11px] font-bold text-red-600 animate-in fade-in slide-in-from-top-1 italic">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="relative group">
                    <label for="password" class="block text-sm font-bold ">
                        Password
                    </label>
                    <input type="password" name="password" 
                        class="w-full border-b border-slate-200 @error('password') border-red-500 @else focus:border-indigo-600 @enderror py-2 bg-transparent text-slate-900 outline-none transition-all text-base font-medium placeholder-slate-200"
                        placeholder="••••••••••••" id="password">

                    @error('password')
                        <p class="mt-1.5 text-[11px] font-bold text-red-600 animate-in fade-in slide-in-from-top-1 italic">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-0 transition-all">
                        <span class="text-xs font-bold text-slate-400 group-hover:text-slate-600 transition-colors">Remember</span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-[#500A0B] text-white py-3.5 rounded-xl font-bold text-[11px] uppercase tracking-[0.2em] hover:bg-black transition-all shadow-lg active:scale-[0.98] flex items-center justify-center gap-2 group">
                        Log In
                        <svg class="w-3.5 h-3.5 opacity-50 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-12 text-center">
                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.3em]">Authorized Personnel Only</p>
            </div>
        </div>
    </div>
</div>
@endsection