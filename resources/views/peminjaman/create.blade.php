@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')

<div class="page-header">
    <h1 class="page-title">Tambah Peminjaman</h1>
    <a href="{{ route('peminjaman.index') }}" class="btn btn-primary">← Kembali</a>
</div>

<div class="form-card">
    <h1>Form Peminjaman Buku</h1>
    <p class="sub">Pilih member dan buku, lalu tentukan tanggal pinjam dan kembali.</p>

    @if($errors->any())
        <div class="alert alert-error" style="flex-direction:column; align-items:flex-start; gap:4px; margin-bottom:22px;">
            <strong>❌ Terdapat kesalahan:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peminjaman.store') }}">
        @csrf

        {{-- Pilih Member --}}
        <div class="field">
            <label>Member <span class="req">*</span></label>
            <select name="member_id" class="{{ $errors->has('member_id') ? 'input-error' : '' }}">
                <option value="">— Pilih Member —</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}"
                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->nomor_member }} – {{ $member->nama_member }}
                    </option>
                @endforeach
            </select>
            @error('member_id')<p class="error-msg">{{ $message }}</p>@enderror
            @if($members->isEmpty())
                <p class="hint" style="color:var(--rust)">
                    ⚠️ Belum ada member terdaftar.
                    <a href="{{ route('member.create') }}">Tambah member dulu.</a>
                </p>
            @endif
        </div>

        {{-- Pilih Buku --}}
        <div class="field">
            <label>Buku <span class="req">*</span></label>
            <select name="buku_id" class="{{ $errors->has('buku_id') ? 'input-error' : '' }}">
                <option value="">— Pilih Buku —</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}"
                        {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                        {{ $buku->judul }} ({{ $buku->penulis }}, {{ $buku->tahun_terbit }})
                    </option>
                @endforeach
            </select>
            @error('buku_id')<p class="error-msg">{{ $message }}</p>@enderror
            @if($bukus->isEmpty())
                <p class="hint" style="color:var(--rust)">
                    ⚠️ Belum ada buku terdaftar.
                    <a href="{{ route('buku.create') }}">Tambah buku dulu.</a>
                </p>
            @endif
        </div>

        {{-- Tanggal Pinjam & Kembali --}}
        <div class="form-row">
            <div class="field">
                <label>Tanggal Pinjam <span class="req">*</span></label>
                <input type="date" name="tgl_pinjam"
                       value="{{ old('tgl_pinjam', now()->format('Y-m-d')) }}"
                       class="{{ $errors->has('tgl_pinjam') ? 'input-error' : '' }}">
                @error('tgl_pinjam')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label>Tanggal Kembali <span class="req">*</span></label>
                <input type="date" name="tgl_kembali"
                       value="{{ old('tgl_kembali', now()->addDays(7)->format('Y-m-d')) }}"
                       class="{{ $errors->has('tgl_kembali') ? 'input-error' : '' }}">
                @error('tgl_kembali')<p class="error-msg">{{ $message }}</p>@enderror
                <p class="hint">Tidak boleh sebelum tanggal pinjam.</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success" style="padding:11px 26px">💾 Simpan Peminjaman</button>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-primary" style="padding:11px 22px">Batal</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    const tglPinjam  = document.querySelector('[name="tgl_pinjam"]');
    const tglKembali = document.querySelector('[name="tgl_kembali"]');

    tglPinjam.addEventListener('change', function () {
        tglKembali.min = this.value;
        if (tglKembali.value && tglKembali.value < this.value) {
            tglKembali.value = this.value;
        }
    });

    if (tglPinjam.value) tglKembali.min = tglPinjam.value;
</script>
@endpush