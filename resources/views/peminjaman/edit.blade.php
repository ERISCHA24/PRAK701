@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')

<div class="page-header">
    <h1 class="page-title">Edit Peminjaman</h1>
    <a href="{{ route('peminjaman.index') }}" class="btn btn-primary">← Kembali</a>
</div>

<div class="form-card">
    <h1>Edit Data Peminjaman</h1>
    <p class="sub">Perbarui data peminjaman. Status <strong>selesai/aktif</strong> hanya bisa diubah via tombol Selesai di tabel.</p>

    @if($errors->any())
        <div class="alert alert-error" style="flex-direction:column; align-items:flex-start; gap:4px; margin-bottom:22px;">
            <strong>❌ Terdapat kesalahan:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- Info status saat ini --}}
    @php $ds = $peminjaman->display_status; @endphp
    <div style="margin-bottom:22px;">
        <span style="font-size:0.85rem; color:#666;">Status saat ini: </span>
        @if($ds === 'aktif')   <span class="badge badge-aktif">Aktif</span>
        @elseif($ds === 'today')  <span class="badge badge-today">Jatuh Tempo Hari Ini</span>
        @elseif($ds === 'overdue') <span class="badge badge-overdue">Terlambat</span>
        @else <span class="badge badge-selesai">Selesai</span>
        @endif
    </div>

    <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}">
        @csrf
        @method('PUT')

        {{-- Pilih Member --}}
        <div class="field">
            <label>Member <span class="req">*</span></label>
            <select name="member_id" class="{{ $errors->has('member_id') ? 'input-error' : '' }}">
                <option value="">— Pilih Member —</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}"
                        {{ old('member_id', $peminjaman->member_id) == $member->id ? 'selected' : '' }}>
                        {{ $member->nomor_member }} – {{ $member->nama_member }}
                    </option>
                @endforeach
            </select>
            @error('member_id')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        {{-- Pilih Buku --}}
        <div class="field">
            <label>Buku <span class="req">*</span></label>
            <select name="buku_id" class="{{ $errors->has('buku_id') ? 'input-error' : '' }}">
                <option value="">— Pilih Buku —</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}"
                        {{ old('buku_id', $peminjaman->buku_id) == $buku->id ? 'selected' : '' }}>
                        {{ $buku->judul }} ({{ $buku->penulis }}, {{ $buku->tahun_terbit }})
                    </option>
                @endforeach
            </select>
            @error('buku_id')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        {{-- Tanggal --}}
        <div class="form-row">
            <div class="field">
                <label>Tanggal Pinjam <span class="req">*</span></label>
                <input type="date" name="tgl_pinjam"
                       value="{{ old('tgl_pinjam', $peminjaman->tgl_pinjam?->format('Y-m-d')) }}"
                       class="{{ $errors->has('tgl_pinjam') ? 'input-error' : '' }}">
                @error('tgl_pinjam')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label>Tanggal Kembali <span class="req">*</span></label>
                <input type="date" name="tgl_kembali"
                       value="{{ old('tgl_kembali', $peminjaman->tgl_kembali?->format('Y-m-d')) }}"
                       class="{{ $errors->has('tgl_kembali') ? 'input-error' : '' }}">
                @error('tgl_kembali')<p class="error-msg">{{ $message }}</p>@enderror
                <p class="hint">Tidak boleh sebelum tanggal pinjam.</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success" style="padding:11px 26px">💾 Simpan Perubahan</button>
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