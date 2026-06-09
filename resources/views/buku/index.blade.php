@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<div class="page-header">
    <h1 class="page-title">Data Buku</h1>
    <a href="{{ route('buku.create') }}" class="btn btn-success">
        ＋ Tambah Buku
    </a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:60px">No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th style="width:120px">Tahun Terbit</th>
                <th style="width:160px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $index => $buku)
            <tr>
                <td><span class="badge">{{ $index + 1 }}</span></td>
                <td><strong>{{ $buku->judul }}</strong></td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->penerbit }}</td>
                <td><span class="badge">{{ $buku->tahun_terbit }}</span></td>
                <td>
                    <div style="display:flex; gap:6px;">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('buku.edit', $buku->id) }}"
                           class="btn btn-edit">✏️ Ubah</a>

                        {{-- Tombol Hapus (menggunakan form DELETE) --}}
                        <form method="POST"
                              action="{{ route('buku.destroy', $buku->id) }}"
                              onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                🗑 Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty-state">
                    📭 Belum ada data buku. Klik <strong>Tambah Buku</strong> untuk memulai.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
