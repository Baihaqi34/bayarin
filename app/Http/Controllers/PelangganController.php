<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
   
        $pelanggan = Pelanggan::with('paket')->orderBy('id', 'desc')->paginate(perPage: 1);
        $paket = Paket::all();
        return view('admin.pelanggan.index', compact('pelanggan','paket'));
    }

    public function cari(Request $request)
    {
        $search = $request->query('search');
        $pelanggan = Pelanggan::with('paket')
            ->where('nama', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $paket = Paket::all();
        return view('admin.pelanggan.index', compact('pelanggan', 'paket'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_paket' => 'required|integer',
            'tagihan' => 'required|integer',
            'tanggal_bayar' => 'required|',
            'status' => 'required|string|max:255',
        ]);

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_paket' => 'required|integer',
            'tagihan' => 'required|integer',
            'tanggal_bayar' => 'required|string|max:10',
            'status' => 'required|string|max:255',
        ]);

        $pelanggan->update($data);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}

