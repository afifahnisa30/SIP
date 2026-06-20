@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Pengeluaran</h2>
        <p class="text-xs text-gray-400 mt-1">Catat biaya operasional CV Salam Indah</p>
    </div>
    <button onclick="openTambahModal()"
        class="flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl shadow hover:opacity-90 transition">
        <i class="fas fa-plus"></i> Tambah Pengeluaran
    </button>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-[#DC2626] p-5 rounded-2xl shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-white text-sm"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">
                {{ request('dari') && request('sampai') ? request('dari') . ' s/d ' . request('sampai') : 'Hari ini' }}
            </span>
        </div>
        <p class="text-xl font-black mb-0.5">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p class="text-xs text-red-100 uppercase tracking-widest font-medium">Total Pengeluaran</p>
    </div>

    <div class="bg-[#2563EB] p-5 rounded-2xl shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-white text-sm"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">Tunai</span>
        </div>
        <p class="text-xl font-black mb-0.5">Rp {{ number_format($pengeluaranTunai, 0, ',', '.') }}</p>
        <p class="text-xs text-amber-100 uppercase tracking-widest font-medium">Pengeluaran Tunai</p>
    </div>

    <div class="bg-[#7C3AED] p-5 rounded-2xl shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-university text-white text-sm"></i>
            </div>
            <span class="text-xs bg-white/20 px-2 py-1 rounded-full font-medium">Transfer</span>
        </div>
        <p class="text-xl font-black mb-0.5">Rp {{ number_format($pengeluaranTransfer, 0, ',', '.') }}</p>
        <p class="text-xs text-purple-100 uppercase tracking-widest font-medium">Pengeluaran Transfer</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- FILTER --}}
<form method="GET" action="{{ route('pengeluaran.index') }}" class="flex flex-wrap gap-3 mb-6">
    <select name="kategori"
        class="min-w-[160px] py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        <option value="">Semua Kategori</option>
        <option value="Listrik" {{ request('kategori') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
        <option value="Makan Karyawan" {{ request('kategori') == 'Makan Karyawan' ? 'selected' : '' }}>Makan Karyawan</option>
        <option value="Internet" {{ request('kategori') == 'Internet' ? 'selected' : '' }}>Internet</option>
        <option value="Expedisi" {{ request('kategori') == 'Expedisi' ? 'selected' : '' }}>Expedisi</option>
        <option value="Umum" {{ request('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
    </select>

    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-500 font-medium">Dari</label>
        <input type="date" name="dari" value="{{ request('dari', today()->toDateString()) }}"
            class="py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-500 font-medium">Sampai</label>
        <input type="date" name="sampai" value="{{ request('sampai', today()->toDateString()) }}"
            class="py-2.5 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>

    <button type="submit"
        class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold rounded-2xl hover:opacity-90 transition">
        <i class="fas fa-filter mr-1"></i> Filter
    </button>
    @if(request('kategori') || request('dari') || request('sampai'))
    <a href="{{ route('pengeluaran.index') }}"
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
                    <th class="px-5 py-4 text-left">No</th>
                    <th class="px-5 py-4 text-left">Tanggal</th>
                    <th class="px-5 py-4 text-left">Kategori</th>
                    <th class="px-5 py-4 text-left">Keterangan</th>
                    <th class="px-5 py-4 text-left">Harga</th>
                    <th class="px-5 py-4 text-left">Metode</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pengeluaran as $item)
                <tr class="text-gray-700 hover:bg-slate-50 transition">
                    <td class="px-5 py-3 text-gray-400">
                        {{ ($pengeluaran->currentPage() - 1) * $pengeluaran->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="px-5 py-3">{{ $item->keterangan }}</td>
                    <td class="px-5 py-3 font-semibold text-red-500">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $item->metode_bayar == 'Tunai' ? 'bg-amber-50 text-amber-600' : 'bg-purple-50 text-purple-600' }}">
                            {{ $item->metode_bayar }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                onclick="openEditModal({{ $item->id }}, '{{ $item->tanggal->format('Y-m-d') }}', '{{ $item->kategori }}', '{{ addslashes($item->keterangan) }}', {{ $item->harga }}, '{{ $item->metode_bayar }}')"
                                class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-100 transition">
                                <i class="fas fa-pen text-xs"></i>
                            </button>
                            <form action="{{ route('pengeluaran.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus pengeluaran ini?')">
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
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-xs">
                        <i class="fas fa-receipt text-2xl mb-2 block"></i>
                        Belum ada data pengeluaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pengeluaran->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $pengeluaran->links() }}
    </div>
    @endif
</div>

{{-- MODAL TAMBAH --}}
<div id="tambahModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full border border-gray-100">
        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 text-white flex justify-between items-center rounded-t-3xl">
            <h3 class="text-lg font-black">Tambah Pengeluaran</h3>
            <button type="button" onclick="closeTambahModal()" class="text-white/80 hover:text-white text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('pengeluaran.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @if($errors->any())
                <div class="p-3 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-xs">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Kategori</label>
                <select name="kategori"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Listrik" {{ old('kategori') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    <option value="Makan Karyawan" {{ old('kategori') == 'Makan Karyawan' ? 'selected' : '' }}>Makan Karyawan</option>
                    <option value="Internet" {{ old('kategori') == 'Internet' ? 'selected' : '' }}>Internet</option>
                    <option value="Expedisi" {{ old('kategori') == 'Expedisi' ? 'selected' : '' }}>Expedisi</option>
                    <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: Bayar listrik bulan Juni"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 250000"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Metode Pembayaran</label>
                <select name="metode_bayar"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="Tunai" {{ old('metode_bayar') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="Transfer" {{ old('metode_bayar') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeTambahModal()"
                    class="w-1/3 border border-gray-200 text-gray-500 text-sm font-bold py-2.5 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="w-2/3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold py-2.5 rounded-xl hover:opacity-90 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full border border-gray-100">
        <div class="bg-gradient-to-r from-amber-400 to-orange-500 p-6 text-white flex justify-between items-center rounded-t-3xl">
            <h3 class="text-lg font-black">Edit Pengeluaran</h3>
            <button type="button" onclick="closeEditModal()" class="text-white/80 hover:text-white text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="editTanggal"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Kategori</label>
                <select name="kategori" id="editKategori"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="Listrik">Listrik</option>
                    <option value="Makan Karyawan">Makan Karyawan</option>
                    <option value="Internet">Internet</option>
                    <option value="Expedisi">Expedisi</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Keterangan</label>
                <input type="text" name="keterangan" id="editKeterangan"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" id="editHarga"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Metode Pembayaran</label>
                <select name="metode_bayar" id="editMetode"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeEditModal()"
                    class="w-1/3 border border-gray-200 text-gray-500 text-sm font-bold py-2.5 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="w-2/3 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-sm font-bold py-2.5 rounded-xl hover:opacity-90 transition">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal Tambah
    function openTambahModal() {
        document.getElementById('tambahModal').classList.remove('hidden');
    }
    function closeTambahModal() {
        document.getElementById('tambahModal').classList.add('hidden');
    }

    // Modal Edit
    function openEditModal(id, tanggal, kategori, keterangan, harga, metode) {
        document.getElementById('editForm').action = '/admin/pengeluaran/' + id;
        document.getElementById('editTanggal').value = tanggal;
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editKeterangan').value = keterangan;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editMetode').value = metode;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Auto buka modal tambah kalau ada error validasi
    @if($errors->any())
        openTambahModal();
    @endif
</script>
@endpush