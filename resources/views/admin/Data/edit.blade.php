@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <a href="{{ $user->role == 'admin' ? route('data.admin') : route('data.pelanggan') }}"
        class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-2 transition">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="max-w-lg mx-auto">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-black text-gray-800 mb-1">Edit Pengguna</h2>
        <p class="text-xs text-gray-400 mb-6">Perbarui informasi pengguna</p>

        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('data.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">No. HP</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Role</label>
                <select name="role"
                    class="w-full py-2.5 px-4 text-sm text-gray-700 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3 rounded-xl hover:opacity-90 transition text-sm">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection