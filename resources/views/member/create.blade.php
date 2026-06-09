@extends('layouts.app')

@section('title', 'Tambah Member')

@section('content')

<div class="page-header">
    <h1 class="page-title">Tambah Member</h1>
    <a href="{{ route('member.index') }}" class="btn btn-primary">← Kembali</a>
</div>

<div class="form-card">
    <h1>Daftarkan Member Baru</h1>
    <p class="sub">Kolom bertanda <span style="color:var(--rust)">*</span> wajib diisi.</p>

    @if($errors->any())
        <div class="alert alert-error" style="flex-direction:column; align-items:flex-start; gap:4px; margin-bottom:22px;">
            <strong>❌ Terdapat kesalahan:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('member.store') }}">
        @csrf

        {{-- Nama Member --}}
        <div class="field">
            <label>Nama Member <span class="req">*</span></label>
            <input type="text" name="nama_member"
                   value="{{ old('nama_member') }}"
                   placeholder="Masukkan nama lengkap"
                   class="{{ $errors->has('nama_member') ? 'input-error' : '' }}">
            @error('nama_member')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        {{-- Nomor Member --}}
        <div class="field">
            <label>Nomor Member <span class="req">*</span></label>
            <input type="text" name="nomor_member"
                   value="{{ old('nomor_member') }}"
                   maxlength="15"
                   placeholder="Contoh: M004"
                   class="{{ $errors->has('nomor_member') ? 'input-error' : '' }}">
            @error('nomor_member')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        {{-- Alamat --}}
        <div class="field">
            <label>Alamat</label>
            <textarea name="alamat" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
            @error('alamat')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        {{-- Tanggal Mendaftar & Terakhir Bayar --}}
        <div class="form-row">
            <div class="field">
                <label>Tanggal Mendaftar <span class="req">*</span></label>
                <input type="datetime-local" name="tgl_mendaftar"
                       value="{{ old('tgl_mendaftar', now()->format('Y-m-d\TH:i')) }}"
                       class="{{ $errors->has('tgl_mendaftar') ? 'input-error' : '' }}">
                @error('tgl_mendaftar')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label>Tgl. Terakhir Bayar</label>
                <input type="date" name="tgl_terakhir_bayar"
                       value="{{ old('tgl_terakhir_bayar') }}">
                <p class="hint">Kosongkan jika belum pernah bayar.</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success" style="padding:11px 26px">💾 Simpan Member</button>
            <a href="{{ route('member.index') }}" class="btn btn-primary" style="padding:11px 22px">Batal</a>
        </div>
    </form>
</div>

@endsection