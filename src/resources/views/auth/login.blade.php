@extends('layouts.auth')

@section('content')
<div class="flex min-h-screen bg-[#FAFAFA] antialiased">
    
    <div class="hidden lg:flex lg:w-[42%] bg-[#09090B] p-16 flex-col justify-between relative">
        <div class="absolute inset-0 opacity-[0.15]" style="background-image: radial-gradient(#27272a 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-2xl">
                    <span class="text-black font-black text-lg tracking-tighter">YC</span>
                </div>
                <div class="h-4 w-[1px] bg-zinc-800 mx-1"></div>
                <span class="text-zinc-500 font-medium text-[11px] uppercase tracking-[0.3em]">Debriefing System</span>
            </div>
        </div>

        <div class="relative z-10">
            <h1 class="text-5xl font-bold text-white tracking-tighter leading-[1.1] mb-6">
                Institutional <br> 
                <span class="text-zinc-500">Intelligence.</span>
            </h1>
            <p class="text-zinc-400 text-lg font-medium max-w-sm leading-relaxed">
                The centralized engine for competence validation and pedagogical tracking at YouCode.
            </p>
        </div>

        <div class="relative z-10 pt-8 border-t border-zinc-800">
            <span class="text-[10px] font-bold text-zinc-600 uppercase tracking-[0.4em]">Secure Access Layer v2.0</span>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center p-8 lg:p-24">
        <div class="w-full max-w-[360px]">
            
            <header class="mb-12">
                <h2 class="text-3xl font-extrabold text-zinc-900 tracking-tighter">Log In</h2>
                <p class="text-zinc-500 mt-2 font-medium text-sm">Access the YouCode debriefing system account.</p>
            </header>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <div>
                        <label for="email" class="text-[10px] font-bold @if($errors->has('email') || $errors->has('info')) text-red-500 @else text-zinc-400 @enderror uppercase tracking-[0.2em]">
                            Email
                        </label>
                        @error('info')
                            <p class="text-[11px] font-bold text-red-600 mt-1.5 flex items-center gap-1.5">
                                <span class="w-1 h-1 bg-red-600 rounded-full"></span> 
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full bg-white border @if($errors->has('email') || $errors->has('info')) border-red-500 ring-1 ring-red-500 @else border-zinc-200 focus:border-zinc-900 @endif rounded-xl px-4 py-3 text-sm font-semibold text-zinc-900 outline-none transition-all placeholder:text-zinc-300"
                        placeholder="user@youcode.ma">
                    
                    @error('email')
                        <p class="text-[11px] font-bold text-red-600 mt-1.5 flex items-center gap-1.5">
                            <span class="w-1 h-1 bg-red-600 rounded-full"></span> 
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-[10px] font-bold @if($errors->has('password') || $errors->has('info')) text-red-500 @else text-zinc-400 @endif uppercase tracking-[0.2em]">
                            Password
                        </label>
                    </div>
                    <input type="password" name="password" id="password"
                        class="w-full bg-white border @if($errors->has('password') || $errors->has('info')) border-red-500 ring-1 ring-red-500 @else border-zinc-200 focus:border-zinc-900 @enderror rounded-xl px-4 py-3 text-sm font-semibold text-zinc-900 outline-none transition-all placeholder:text-zinc-300"
                        placeholder="••••••••••••">
                    
                    @error('password')
                        <p class="text-[11px] font-bold text-red-600 mt-1.5 flex items-center gap-1.5">
                            <span class="w-1 h-1 bg-red-600 rounded-full"></span> 
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded-md border-zinc-300 text-zinc-900 focus:ring-0 transition-all">
                        <span class="text-xs font-bold text-zinc-400 group-hover:text-zinc-900 transition-colors uppercase tracking-tighter">Remember me</span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-zinc-900 text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-black transition-all active:scale-[0.98] shadow-lg shadow-zinc-200 flex items-center justify-center gap-2">
                        Log In
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>

            <footer class="mt-16 text-center">
                <p class="text-[9px] font-bold text-zinc-300 uppercase tracking-[0.3em]">Authorized Access Only</p>
            </footer>
        </div>
    </div>
</div>
@endsection