<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai filter, default ke bulan & tahun sekarang
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);
        $nama  = $request->input('nama');

        $query = Tagihan::with('pelanggan')
            ->orderBy('periode', 'desc')
            ->orderBy('id', 'desc');

        // WAJIB filter bulan & tahun (default atau dari user)
        $query->whereMonth('periode', $bulan)
            ->whereYear('periode', $tahun);

        // Filter nama pelanggan jika ada
        if (!empty($nama)) {
            $query->whereHas('pelanggan', function ($q) use ($nama) {
                $q->where('nama', 'like', '%' . $nama . '%');
            });
        }

        $tagihan = $query->paginate(10)->appends($request->query());

        $pelangganList = Pelanggan::where('status', 'aktif')
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return view('admin.tagihan.index', [
            'tagihan' => $tagihan,
            'pelangganList' => $pelangganList,
            'filters' => [
                'nama' => $nama,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
        ]);
    }

  

    public function update(Request $request, Tagihan $tagihan)
    {
        $data = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'nominal' => 'required|integer',
            'periode' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $tagihan->update($data);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diperbarui');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus');
    }

    public function generateBulanan(Request $request)
    {
        $now = Carbon::now();
        $tahun = (int)($request->input('tahun') ?: $now->year);
        $bulan = (int)($request->input('bulan') ?: $now->month);
        $periode = Carbon::create($tahun, $bulan, 1)->toDateString();

        $pelanggan = Pelanggan::where('status', 'aktif')->get();
        $dibuat = 0;

        foreach ($pelanggan as $p) {
            $tanggal_bayar = (int)($p->tanggal_bayar ?: 1);
            $day = Carbon::createFromDate($tahun, $bulan, $tanggal_bayar)->day;
            $lastDay = Carbon::create($tahun, $bulan, 1)->endOfMonth()->day;
            $dueDay = min($day, $lastDay);
            $jatuhTempo = Carbon::create($tahun, $bulan, $dueDay)->toDateString();

            $exists = Tagihan::where('pelanggan_id', $p->id)
                ->where('periode', $periode)
                ->exists();

            if (!$exists) {
                Tagihan::create([
                    'pelanggan_id' => $p->id,
                    'nominal' => $p->tagihan,
                    'periode' => $periode,
                    'jatuh_tempo' => $jatuhTempo,
                    'status' => 'belum_dibayar',
                ]);
                $dibuat++;
            }
        }

        return redirect()->route('tagihan.index')->with('success', "Generate tagihan bulan $bulan/$tahun: $dibuat dibuat");
    }

    public function pay(Request $request, Tagihan $tagihan)
    {
        $data = $request->validate([
            'tanggal_bayar' => 'nullable|date',
        ]);
        $tagihan->status = 'lunas';
        $tagihan->dibayar_at = !empty($data['tanggal_bayar']) ? Carbon::parse($data['tanggal_bayar']) : now();
        $tagihan->save();
        return redirect()->route('tagihan.print', $tagihan->id);
    }

    public function print(Tagihan $tagihan)
    {
        $pelanggan = Pelanggan::find($tagihan->pelanggan_id);
        return view('admin.tagihan.print', compact('tagihan', 'pelanggan'));
    }
}
