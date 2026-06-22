@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Data Pelanggan</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola data pelanggan Percetakan Salam Indah</p>
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

{{-- SEARCH & FILTER --}}
<form method="GET" action="{{ route('data.pelanggan') }}" class="flex flex-wrap gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama, email, atau nomor HP..."
            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <select name="kategori"
        class="min-w-[160px] py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        <option value="">Semua</option>
        <option value="Online" {{ request('kategori') == 'Online' ? 'selected' : '' }}>Online</option>
        <option value="Offline" {{ request('kategori') == 'Offline' ? 'selected' : '' }}>Offline</option>
    </select>
    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-search mr-1"></i> Cari
    </button>
    @if(request('search') || request('kategori'))
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
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Tipe</th>
                    <th class="px-6 py-4 text-left">Tgl Daftar</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pelanggan as $i => $p)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-gray-400">
                        {{ ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $p['kategori'] == 'Online' ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600' }} rounded-full flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($p['nama'], 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $p['nama'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $p['email'] }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $p['no_telp'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $p['kategori'] == 'Online' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ $p['kategori'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $p['tipe'] == 'Reseller' ? 'bg-purple-50 text-purple-600' : 'bg-gray-50 text-gray-500' }}">
                            {{ $p['tipe'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $p['tgl_daftar'] }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            @if($p['is_user'])
                            <a href="{{ route('data.edit', $p['id']) }}"
                                class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-100 transition">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('data.destroy', $p['id']) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-100 transition">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-gray-300 italic">Walk-in</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-users text-2xl mb-2 block"></i>
                        Belum ada pelanggan terdaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pelanggan->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $pelanggan->links() }}
    </div>
    @endif
</div>

@endsection