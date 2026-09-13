<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BarangController extends Controller
{
    // ✅ List barang dengan filter & search
    public function index(Request $request): View
    {
        $query = Barang::orderBy('created_at', 'desc');

        // 🔎 Filter tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // 🔎 Search nama barang
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barang = $query->paginate(10)->withQueryString();

        return view('barang.index', compact('barang'));
    }

    // ✅ Form tambah barang baru
    public function create(): View
    {
        $kodeBarang = $this->generateKodeBarang();
        return view('barang.create', compact('kodeBarang'));
    }

    // ✅ Simpan barang baru
        public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            //'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',

        ]);

        // cek apakah barang sudah ada
        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        if ($barang) {
            // kalau sudah ada, update stok saja
            $barang->stok += $request->stok;
            $barang->save();
        } else {
            // kalau belum ada, buat barang baru
            $kodeBarang = $this->generateKodeBarang();

            Barang::create([
                'Kode_Barang' => $kodeBarang,
                'nama_barang' => $request->nama_barang,
                //'kategori' => $request->kategori, 
                'stok' => $request->stok,
            ]);
        }

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan / diupdate stoknya!');
    }

    /**
     * ✅ Generate kode barang baru dengan format BRGxxx
     */
    private function generateKodeBarang()
    {
        // ambil kode barang terakhir
        $lastBarang = Barang::orderBy('Kode_Barang', 'desc')->first();

        if (!$lastBarang) {
            return 'BRG001'; // kalau belum ada data
        }

        // Ambil angka dari kode terakhir, misalnya BRG020 → 20
        $lastNumber = intval(substr($lastBarang->Kode_Barang, 3));

        // Tambah 1 → format ulang BRGxxx
        return 'BRG' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    // ✅ Form edit
    public function edit($id): View
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    // ✅ Update barang
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'stok'        => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'stok'        => $request->stok,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    // ✅ Hapus barang
    public function destroy($id): RedirectResponse
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
