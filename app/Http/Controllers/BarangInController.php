<?php

namespace App\Http\Controllers;

use App\Models\BarangIn;
use App\Models\Barang;
use App\Models\LogHistory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BarangInController extends Controller
{
    /**
     * ✅ Tampilkan semua barang masuk + fitur filter (search & tanggal)
     */
    public function index(Request $request): View
    {
        $query = BarangIn::with('barang');

        // 🔍 Filter berdasarkan nama_barang atau jumlah
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('jumlah', 'like', '%' . $search . '%');
            });
        }

        // 📅 Filter berdasarkan range tanggal_masuk
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_masuk', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal_masuk', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal_masuk', '<=', $request->to);
        }

        // ✅ Urutkan berdasarkan waktu input terbaru (NULL terakhir)
        $barangIn = $query->orderByRaw('created_at IS NULL')
                          ->orderBy('created_at', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate(10);

        return view('barang_in.index', compact('barangIn'));
    }

    /**
     * Form tambah barang masuk
     */
    public function create(): View
    {
        $barang = Barang::all();
        return view('barang_in.create', compact('barang'));
    }

    /**
     * Simpan barang masuk
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_barang'    => 'required|string',
            'kategori'    => 'nullable|string',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_masuk'  => 'required|date',
        ]);

        // Simpan barang masuk
        $barangIn = BarangIn::create([
            'nama_barang'    => $request->nama_barang,
            'kategori'         => $request->kategori,
            'jumlah'         => $request->jumlah,
            'tanggal_masuk'  => $request->tanggal_masuk,
        ]);

        // Update stok di tabel Barang
        $barang = Barang::where('nama_barang', $request->nama_barang)->first();
        if ($barang) {
            $barang->stok += $request->jumlah;
            $barang->save();

            // ✅ Catat log history
            LogHistory::create([
                'user_id'       => Auth::id(),
                'aksi'          => 'Tambah Barang Masuk',
                'nama_barang'   => $request->nama_barang,
                'jumlah'        => $request->jumlah,
                'stok_sekarang' => $barang->stok,
                'waktu'         => now(),
            ]);
        }

        return redirect()->route('barang_in.index')
                         ->with('success', 'Barang masuk berhasil ditambahkan');
    }

    /**
     * Detail barang masuk
     */
    public function show(BarangIn $barangIn): View
    {
        return view('barang_in.show', compact('barangIn'));
    }

    /**
     * Form edit barang masuk
     */
    public function edit($id): View
    {
        $barangIn = BarangIn::findOrFail($id);
        return view('barang_in.edit', compact('barangIn'));
    }

    /**
     * Update barang masuk
     */
    public function update(Request $request, BarangIn $barangIn): RedirectResponse
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_masuk'  => 'required|date',
        ]);

        // Cari barang lama
        $barang = Barang::where('nama_barang', $barangIn->nama_barang)->first();
        if (!$barang) {
            return back()->withErrors([
                'nama_barang' => 'Barang tidak ditemukan dalam stok!'
            ])->withInput();
        }

        // Kurangi stok lama sebelum update
        $barang->stok -= $barangIn->jumlah;

        // Tambahkan stok sesuai jumlah baru
        $barangIn->update([
            'nama_barang'    => $request->nama_barang,
            'jumlah'         => $request->jumlah,
            'tanggal_masuk'  => $request->tanggal_masuk,
        ]);

        $barang->stok += $request->jumlah;
        $barang->save();

        // ✅ Catat log
        LogHistory::create([
            'user_id'       => Auth::id(),
            'aksi'          => 'Update Barang Masuk',
            'nama_barang'   => $request->nama_barang,
            'jumlah'        => $request->jumlah,
            'stok_sekarang' => $barang->stok,
            'waktu'         => now(),
        ]);

        return redirect()->route('barang_in.index')
                         ->with('success', 'Barang masuk berhasil diupdate!');
    }

    /**
     * Hapus barang masuk
     */
    public function destroy(BarangIn $barangIn): RedirectResponse
    {
        $barang = Barang::where('nama_barang', $barangIn->nama_barang)->first();

        if ($barang) {
            // Kurangi stok saat data barang masuk dihapus
            $barang->stok -= $barangIn->jumlah;
            $barang->save();
        }

        // ✅ Catat log
        LogHistory::create([
            'user_id'       => Auth::id(),
            'aksi'          => 'Hapus Barang Masuk',
            'nama_barang'   => $barangIn->nama_barang,
            'jumlah'        => $barangIn->jumlah,
            'stok_sekarang' => $barang ? $barang->stok : 0,
            'waktu'         => now(),
        ]);

        $barangIn->delete();

        return redirect()->route('barang_in.index')
                         ->with('success', 'Data barang masuk berhasil dihapus!');
    }
}
