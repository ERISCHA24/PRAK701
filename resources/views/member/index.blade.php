@extends('layouts.app')

@section('title', 'Data Member')

@section('content')

<div class="page-header">
    <h1 class="page-title">Data Member</h1>
    <a href="{{ route('member.create') }}" class="btn btn-success">＋ Tambah Member</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:55px">No</th>
                <th>Nama Member</th>
                <th>No. Member</th>
                <th>Alamat</th>
                <th>Tgl. Mendaftar</th>
                <th>Tgl. Terakhir Bayar</th>
                <th style="width:160px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $i => $member)
            <tr>
                <td><span class="badge badge-default">{{ $i + 1 }}</span></td>
                <td><strong>{{ $member->nama_member }}</strong></td>
                <td>{{ $member->nomor_member }}</td>
                <td>{{ $member->alamat ?? '-' }}</td>
                <td>{{ $member->tgl_mendaftar ? $member->tgl_mendaftar->format('d M Y') : '-' }}</td>
                <td>
                    @if($member->tgl_terakhir_bayar)
                        {{ $member->tgl_terakhir_bayar->format('d M Y') }}
                    @else
                        <span style="color:#ccc">–</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('member.edit', $member->id) }}" class="btn btn-edit">✏️ Ubah</a>
                        <form method="POST" action="{{ route('member.destroy', $member->id) }}"
                              onsubmit="return confirm('Yakin hapus member {{ $member->nama_member }}?\nSemua data peminjaman terkait ikut terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">🗑 Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    📭 Belum ada data member. Klik <strong>Tambah Member</strong> untuk memulai.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection