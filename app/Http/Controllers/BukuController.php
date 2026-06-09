<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    private array $rules = [
        'judul'        => 'required|string',
        'penulis'      => 'required|string',
        'penerbit'     => 'required|string',
        'tahun_terbit' => 'required|numeric|gt:1800|lt:2024',
    ];

    private array $messages = [
        'judul.required'        => 'Judul harus diisi.',
        'judul.string'          => 'Judul harus berupa teks/string.',

        'penulis.required'      => 'Penulis harus diisi.',
        'penulis.string'        => 'Penulis harus berupa teks/string.',

        'penerbit.required'     => 'Penerbit harus diisi.',
        'penerbit.string'       => 'Penerbit harus berupa teks/string.',

        'tahun_terbit.required' => 'Tahun terbit harus diisi.',
        'tahun_terbit.numeric'  => 'Tahun terbit harus berupa angka.',
        'tahun_terbit.gt'       => 'Tahun terbit harus lebih besar dari 1800.',
        'tahun_terbit.lt'       => 'Tahun terbit harus lebih kecil dari 2026.',
    ];

    // READ

    public function index()
    {
        $bukus = Buku::orderBy('id', 'desc')->get();
        return view('buku.index', compact('bukus'));
    }

    // CREATE

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules, $this->messages);

        Buku::create($request->only(['judul', 'penulis', 'penerbit', 'tahun_terbit']));

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    // UPDATE

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate($this->rules, $this->messages);

        $buku->update($request->only(['judul', 'penulis', 'penerbit', 'tahun_terbit']));

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    // DELETE 

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }
}
