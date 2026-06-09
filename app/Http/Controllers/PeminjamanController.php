<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Validasi 

    private array $rules = [
        'member_id'   => 'required|exists:member,id',
        'buku_id'     => 'required|exists:buku,id',
        'tgl_pinjam'  => 'required|date',
        'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
    ];

    private array $messages = [
        'member_id.required'        => 'Member harus dipilih.',
        'member_id.exists'          => 'Member yang dipilih tidak ditemukan.',

        'buku_id.required'          => 'Buku harus dipilih.',
        'buku_id.exists'            => 'Buku yang dipilih tidak ditemukan.',

        'tgl_pinjam.required'       => 'Tanggal pinjam harus diisi.',
        'tgl_pinjam.date'           => 'Format tanggal pinjam tidak valid.',

        'tgl_kembali.required'      => 'Tanggal kembali harus diisi.',
        'tgl_kembali.date'          => 'Format tanggal kembali tidak valid.',
        'tgl_kembali.after_or_equal'=> 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
    ];

    // READ 

    public function index()
    {
        $peminjamans = Peminjaman::with(['member', 'buku'])
            ->orderBy('id', 'desc')
            ->get();

        return view('peminjaman.index', compact('peminjamans'));
    }

    // CREATE

    public function create()
    {
        $members = Member::orderBy('nama_member')->get();
        $bukus   = Buku::orderBy('judul')->get();

        return view('peminjaman.create', compact('members', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules, $this->messages);

        Peminjaman::create($request->only([
            'member_id', 'buku_id', 'tgl_pinjam', 'tgl_kembali',
        ]));

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    // UPDATE 

    public function edit(Peminjaman $peminjaman)
    {
        $members = Member::orderBy('nama_member')->get();
        $bukus   = Buku::orderBy('judul')->get();

        return view('peminjaman.edit', compact('peminjaman', 'members', 'bukus'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate($this->rules, $this->messages);

        $peminjaman->update($request->only([
            'member_id', 'buku_id', 'tgl_pinjam', 'tgl_kembali',
        ]));

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    // DELETE

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }

    /**
     * Tandai peminjaman sebagai 'selesai'.
     * Hanya bisa dilakukan jika status masih 'aktif'.
     */
    public function selesaikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'aktif') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman ini sudah berstatus selesai.');
        }

        $peminjaman->update(['status' => 'selesai']);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditandai sebagai selesai.');
    }
}