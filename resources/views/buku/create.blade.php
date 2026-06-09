@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<div class="page-header">
    <h1 class="page-title">Tambah Buku</h1>
    <a href="{{ route('buku.index') }}" class="btn btn-primary">
        ← Kembali
    </a>
</div>

<div class="form-card">
    <h1>Tambah Data Buku</h1>
    <p class="sub">Isi semua kolom yang bertanda <span style="color:var(--rust)">*</span> dengan benar.</p>

    @if($errors->any())
        <div class="alert alert-error" style="margin-bottom:24px; flex-direction:column; align-items:flex-start; gap:4px;">
            <strong>❌ Terdapat kesalahan pada input:</strong>
            <ul style="padding-left:20px; margin-top:6px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('buku.store') }}">
        @csrf

        {{-- Judul --}}
        <div class="field">
            <label>Judul <span class="req">*</span></label>
            <input
                type="text"
                name="judul"
                value="{{ old('judul') }}"
                placeholder="Masukkan judul buku"
                class="{{ $errors->has('judul') ? 'input-error' : '' }}"
            >
            @error('judul')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- Penulis --}}
        <div class="field">
            <label>Penulis <span class="req">*</span></label>
            <input
                type="text"
                name="penulis"
                value="{{ old('penulis') }}"
                placeholder="Nama penulis"
                class="{{ $errors->has('penulis') ? 'input-error' : '' }}"
            >
            @error('penulis')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- Penerbit --}}
        <div class="field">
            <label>Penerbit <span class="req">*</span></label>
            <input
                type="text"
                name="penerbit"
                value="{{ old('penerbit') }}"
                placeholder="Nama penerbit"
                class="{{ $errors->has('penerbit') ? 'input-error' : '' }}"
            >
            @error('penerbit')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tahun Terbit --}}
        <div class="field">
            <label>Tahun Terbit <span class="req">*</span></label>
            <input
                type="number"
                name="tahun_terbit"
                value="{{ old('tahun_terbit') }}"
                placeholder="Contoh: 2020  (antara 1801 – 2026)"
                min="1801"
                max="2026"
                class="{{ $errors->has('tahun_terbit') ? 'input-error' : '' }}"
            >
            @error('tahun_terbit')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success" style="padding:12px 28px; font-size:0.95rem;">
                💾 Simpan Buku
            </button>
            <a href="{{ route('buku.index') }}" class="btn btn-primary" style="padding:12px 24px;">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
