@extends('layouts.main')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">User Directory</h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Manage accounts. Instructors manage learner class assignments.</p>
        </div>
        
        <button type="button" id="AddNewUser"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 shadow-lg shadow-slate-200 group">
            <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add New User
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php $hasMembers = false; @endphp
        @foreach($users as $user)
            @if($user->role !== 'admin')
            @php $hasMembers = true; @endphp
            <div class="group bg-white border border-slate-100 rounded-[2rem] p-6 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-500/20 transition-all duration-500 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 h-32 w-32 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="h-14 w-14 bg-slate-50 text-slate-900 rounded-2xl flex items-center justify-center font-black text-xl border border-slate-100 group-hover:bg-indigo-600 group-hover:text-white group-hover:scale-110 transition-all duration-500 uppercase">
                            {{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName, 0, 1) }}
                        </div>
                        
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 duration-300">
                            <button type="button" 
                                    onclick="initEdit({ 
                                        id: '{{ $user->id }}', 
                                        firstName: '{{ addslashes($user->firstName) }}', 
                                        lastName: '{{ addslashes($user->lastName) }}', 
                                        email: '{{ $user->email }}', 
                                        role: '{{ $user->role }}', 
                                        classrooms: {{ $user->classrooms ? $user->classrooms->pluck('id') : '[]' }} 
                                    })" 
                                    class="p-2.5 bg-white border border-slate-100 hover:border-indigo-500 text-slate-400 hover:text-indigo-600 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button type="button" onclick="triggerDelete('{{ $user->id }}', '{{ $user->firstName }} {{ $user->lastName }}')" 
                                    class="p-2.5 bg-white border border-slate-100 hover:border-rose-500 text-slate-400 hover:text-rose-600 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>

                    <h3 class="text-lg font-black text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors">{{ $user->firstName }} {{ $user->lastName }}</h3>
                    <p class="text-sm text-slate-400 font-medium mb-6">{{ $user->email }}</p>

                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-50">
                        <div class="p-3 bg-slate-50/50 rounded-2xl group-hover:bg-indigo-50/50 transition-colors">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Role</p>
                            <p class="text-xs font-bold text-slate-700 capitalize">{{ $user->role }}</p>
                        </div>
                        
                        <div class="p-3 bg-slate-50/50 rounded-2xl group-hover:bg-indigo-50/50 transition-colors">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Assigned To</p>
                            <div class="flex flex-wrap gap-1">
                                @if($user->role === 'instructor')
                                    @forelse($user->classrooms as $cls)
                                        <span class="text-[10px] bg-white border border-slate-200 text-slate-700 px-2 py-0.5 rounded-lg font-bold">
                                            {{ $cls->name }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-slate-400 italic">No classes</span>
                                    @endforelse
                                @else
                                    @if($user->classroom)
                                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-lg font-bold border border-indigo-200">
                                            {{ $user->classroom->name }}
                                        </span>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic">None</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        @if(!$hasMembers)
            <div class="col-span-full py-24 border-2 border-dashed border-slate-100 rounded-[3rem] text-center">
                <p class="text-slate-400 font-bold italic">No directory members found.</p>
            </div>
        @endif
    </div>

    <div id="userModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="closeModal()"></div>
        <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden border border-white">
            <div class="p-10 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-8">
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 tracking-tight">Account Settings</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="userForm" method="POST" class="space-y-5">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">First Name</label>
                            <input type="text" name="firstName" id="firstName" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Last Name</label>
                            <input type="text" name="lastName" id="lastName" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" id="email" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    </div>

                    <div id="passwordField" class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Initial Password</label>
                        <input type="password" name="password" id="password" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all">
                    </div>

                    <div id="roleFieldWrapper" class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Role</label>
                        <select name="role" id="role" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none appearance-none transition-all">
                            <option value="learner">Learner</option>
                            <option value="instructor">Instructor</option>
                        </select>
                    </div>

                    <div id="instructorClassroomWrapper" class="hidden space-y-2 border-t border-slate-50 pt-4">
                        <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest ml-1">Assign Instructor to Classrooms</label>
                        <select name="classroom_ids[]" id="classroom_select" multiple class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none min-h-[120px] transition-all">
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-[9px] text-slate-400 font-bold ml-1 italic">Hold Ctrl/Cmd to select multiple classes</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 transition-all active:scale-[0.98]">
                            Save User Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="bg-white max-w-sm w-full rounded-[2.5rem] p-8 relative z-10 text-center shadow-2xl border border-white">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h4 class="text-2xl font-black text-slate-900 mb-2">Delete User?</h4>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">This will permanently remove <span id="targetName" class="font-bold text-slate-900"></span>.</p>
            <div class="flex gap-3">
                <button onclick="closeConfirm()" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">Cancel</button>
                <button id="confirmDeleteBtn" class="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-rose-200">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('userModal');
    const confirmModal = document.getElementById('confirmModal');
    const form = document.getElementById('userForm');
    const roleSelect = document.getElementById('role');
    const instructorClassroomWrapper = document.getElementById('instructorClassroomWrapper');
    const classroomSelect = document.getElementById('classroom_select');
    const roleWrapper = document.getElementById('roleFieldWrapper');
    let currentDeleteId = null;

    function toggleClassroomView() {
        if (roleSelect.value === 'instructor') {
            instructorClassroomWrapper.classList.remove('hidden');
        } else {
            instructorClassroomWrapper.classList.add('hidden');
            Array.from(classroomSelect.options).forEach(opt => opt.selected = false);
        }
    }

    roleSelect.addEventListener('change', toggleClassroomView);

    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        form.reset();
        roleWrapper.classList.remove('hidden');
        toggleClassroomView();
    }

    document.getElementById('AddNewUser').addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Create Account';
        form.action = "{{ route('admin.users.store') }}";
        document.getElementById('methodContainer').innerHTML = '';
        document.getElementById('passwordField').classList.remove('hidden');
        document.getElementById('password').required = true;
        openModal();
    });

    function initEdit(user) {
        document.getElementById('modalTitle').innerText = 'Edit User Profile';
        form.action = `/admin/users/${user.id}`;
        document.getElementById('methodContainer').innerHTML = '@method("PUT")';
        
        document.getElementById('firstName').value = user.firstName;
        document.getElementById('lastName').value = user.lastName;
        document.getElementById('email').value = user.email;
        roleSelect.value = user.role;
        
        toggleClassroomView();

        if (user.role === 'instructor') {
            Array.from(classroomSelect.options).forEach(option => {
                option.selected = user.classrooms.includes(parseInt(option.value));
            });
        }

        roleWrapper.classList.add('hidden');
        document.getElementById('passwordField').classList.add('hidden');
        document.getElementById('password').required = false;
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