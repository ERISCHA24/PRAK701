@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<div class="page-header">
    <h1 class="page-title">Data Peminjaman</h1>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-success">＋ Tambah Peminjaman</a>
</div>


<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th>Member</th>
                <th>Buku</th>
                <th>Tgl. Pinjam</th>
                <th>Tgl. Kembali</th>
                <th style="width:130px">Status</th>
                <th style="width:220px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $i => $p)
            @php $ds = $p->display_status; @endphp
            <tr>
                <td><span class="badge badge-default">{{ $i + 1 }}</span></td>

                <td>
                    <strong>{{ $p->member->nama_member ?? '–' }}</strong>
                    <br>
                    <small style="color:#999">{{ $p->member->nomor_member ?? '' }}</small>
                </td>

                <td>
                    <strong>{{ $p->buku->judul ?? '–' }}</strong>
                    <br>
                    <small style="color:#999">{{ $p->buku->penulis ?? '' }}</small>
                </td>

                <td>{{ $p->tgl_pinjam?->format('d M Y') }}</td>

                <td>
                    {{ $p->tgl_kembali?->format('d M Y') }}
                    @if($ds === 'overdue')
                        @php
                            $selisih = abs((int) \Carbon\Carbon::today()->diffInDays($p->tgl_kembali));
                        @endphp
                        <br><small style="color:#dc2626">{{ $selisih }} hari terlambat</small>
                    @endif
                </td>

                <td>
                    @if($ds === 'aktif')
                        <span class="badge badge-aktif">Aktif</span>
                    @elseif($ds === 'today')
                        <span class="badge badge-today">Hari Ini</span>
                    @elseif($ds === 'overdue')
                        <span class="badge badge-overdue">Terlambat</span>
                    @else
                        <span class="badge badge-selesai">Selesai</span>
                    @endif
                </td>

                <td>
                    <div style="display:flex; gap:5px; flex-wrap:wrap;">

                        {{-- Tombol Selesaikan (hanya jika masih aktif) --}}
                        @if($p->status === 'aktif')
                            <form method="POST"
                                  action="{{ route('peminjaman.selesai', $p->id) }}"
                                  onsubmit="return confirm('Tandai peminjaman ini sebagai selesai?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-blue">✔ Selesai</button>
                            </form>
                        @else
                            <span class="btn btn-disabled">✔ Selesai</span>
                        @endif

                        {{-- Tombol Edit --}}
                        <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-edit">✏️</a>

                        {{-- Tombol Hapus --}}
                        <form method="POST"
                              action="{{ route('peminjaman.destroy', $p->id) }}"
                              onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">🗑</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    📭 Belum ada data peminjaman. Klik <strong>Tambah Peminjaman</strong> untuk memulai.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection