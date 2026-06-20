@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Data Pelanggan</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola data pelanggan CV Salam Indah</p>
    </div>
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
<form method="GET" action="{{ route('data.pelanggan') }}" class="flex gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama, email, atau nomor HP..."
            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-search mr-1"></i> Cari
    </button>
    @if(request('search'))
    <a href="{{ route('data.pelanggan') }}"
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
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
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
                            <form action="{{ route('data.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-100 transition">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-users text-2xl mb-2 block"></i>
                        Belum ada pelanggan terdaftar
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

@endsection