<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $paket = Paket::orderBy('id', 'desc')->paginate(10);
        return view('admin.paket.index', compact('paket'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        Paket::create($data);
        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function update(Request $request, Paket $paket)
    {
        $data = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        $paket->update($data);
        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus');
    }
}

