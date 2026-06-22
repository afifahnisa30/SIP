@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Data Admin</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola akun admin Percetakan Salam Indah</p>
    </div>
    <button onclick="document.getElementById('modalTambahAdmin').classList.remove('hidden')"
        class="flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl shadow hover:opacity-90 transition">
        <i class="fas fa-plus"></i> Tambah Admin
    </button>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

{{-- SEARCH --}}
<form method="GET" action="{{ route('data.admin') }}" class="flex gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-search mr-1"></i> Cari
    </button>
    @if(request('search'))
    <a href="{{ route('data.admin') }}"
        class="px-5 py-2.5 bg-slate-100 text-slate-500 text-sm font-semibold rounded-2xl hover:bg-slate-200 transition">
        <i class="fas fa-times mr-1"></i> Reset
    </a>
    @endif
</form>

{{-- TABEL --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs text-gray-400 uppercase tracking-widest border-b border-gray-100">
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">No. HP</th>
                    <th class="px-6 py-4 text-left">Tgl Daftar</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-gray-400">
                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-cyan-100 text-cyan-600 rounded-full flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                <span class="ml-1 px-1.5 py-0.5 bg-cyan-100 text-cyan-600 text-[10px] rounded-full font-bold">Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->phone_number }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('data.edit', $user->id) }}"
                                class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-100 transition">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('data.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus admin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-100 transition">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-user-shield text-2xl mb-2 block"></i>
                        Belum ada admin terdaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- MODAL TAMBAH ADMIN --}}
<div id="modalTambahAdmin" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full border border-gray-100">
        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 text-white flex justify-between items-center rounded-t-3xl">
            <h3 class="text-lg font-black">Tambah Admin Baru</h3>
            <button type="button" onclick="document.getElementById('modalTambahAdmin').classList.add('hidden')"
                class="text-white/80 hover:text-white text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('data.tambahAdmin') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email (opsional)"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">No. HP</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Nomor HP"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambahAdmin').classList.add('hidden')"
                    class="w-1/3 border border-gray-200 text-gray-500 text-sm font-bold py-2.5 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="w-2/3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold py-2.5 rounded-xl hover:opacity-90 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Admin
                </button>
            </div>
        </form>
    </div>
</div>

@endsection