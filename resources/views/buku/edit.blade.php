@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')

<div class="page-header">
    <h1 class="page-title">Edit Buku</h1>
    <a href="{{ route('buku.index') }}" class="btn btn-primary">
        ← Kembali
    </a>
</div>

<div class="form-card">
    <h1>Edit Data Buku</h1>
    <p class="sub">Perbarui informasi buku. Kolom bertanda <span style="color:var(--rust)">*</span> wajib diisi.</p>

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

    {{-- Route UPDATE menggunakan method PUT --}}
    <form method="POST" action="{{ route('buku.update', $buku->id) }}">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="field">
            <label>Judul <span class="req">*</span></label>
            <input
                type="text"
                name="judul"
                value="{{ old('judul', $buku->judul) }}"
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
                value="{{ old('penulis', $buku->penulis) }}"
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
                value="{{ old('penerbit', $buku->penerbit) }}"
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
                value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
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
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('buku.index') }}" class="btn btn-primary" style="padding:12px 24px;">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
