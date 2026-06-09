<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Aturan validasi 

    private function rules(int $excludeId = 0): array
    {
        return [
            'nama_member'        => 'required|string|max:250',
            'nomor_member'       => 'required|string|max:15|unique:member,nomor_member,' . $excludeId,
            'alamat'             => 'nullable|string',
            'tgl_mendaftar'      => 'required|date',
            'tgl_terakhir_bayar' => 'nullable|date',
        ];
    }

    private array $messages = [
        'nama_member.required'       => 'Nama member harus diisi.',
        'nama_member.string'         => 'Nama member harus berupa teks.',
        'nama_member.max'            => 'Nama member maksimal 250 karakter.',

        'nomor_member.required'      => 'Nomor member harus diisi.',
        'nomor_member.string'        => 'Nomor member harus berupa teks.',
        'nomor_member.max'           => 'Nomor member maksimal 15 karakter.',
        'nomor_member.unique'        => 'Nomor member sudah digunakan member lain.',

        'tgl_mendaftar.required'     => 'Tanggal mendaftar harus diisi.',
        'tgl_mendaftar.date'         => 'Format tanggal mendaftar tidak valid.',

        'tgl_terakhir_bayar.date'    => 'Format tanggal terakhir bayar tidak valid.',
    ];

    //  READ 

    public function index()
    {
        $members = Member::orderBy('id', 'desc')->get();
        return view('member.index', compact('members'));
    }

    //  CREATE

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages);

        Member::create([
            'nama_member'        => $request->nama_member,
            'nomor_member'       => $request->nomor_member,
            'alamat'             => $request->alamat,
            'tgl_mendaftar'      => $request->tgl_mendaftar,
            'tgl_terakhir_bayar' => $request->tgl_terakhir_bayar ?: null,
        ]);

        return redirect()->route('member.index')
            ->with('success', 'Data member berhasil ditambahkan.');
    }

    // UPDATE
    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate($this->rules($member->id), $this->messages);

        $member->update([
            'nama_member'        => $request->nama_member,
            'nomor_member'       => $request->nomor_member,
            'alamat'             => $request->alamat,
            'tgl_mendaftar'      => $request->tgl_mendaftar,
            'tgl_terakhir_bayar' => $request->tgl_terakhir_bayar ?: null,
        ]);

        return redirect()->route('member.index')
            ->with('success', 'Data member berhasil diperbarui.');
    }

    // DELETE 

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('member.index')
            ->with('success', 'Data member berhasil dihapus.');
    }
}