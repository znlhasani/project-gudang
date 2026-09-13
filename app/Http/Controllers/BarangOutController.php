<?php

namespace App\Http\Controllers;

use App\Models\BarangOut;
use App\Models\Barang;
use App\Models\LogHistory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BarangOutController extends Controller
{
    /**
     * ✅ Tampilkan semua barang keluar + fitur filter (search & tanggal)
     */
    public function index(Request $request): View
    {
        $query = BarangOut::query();

        // 🔍 Filter berdasarkan nama_barang atau jumlah
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('jumlah', 'like', '%' . $search . '%');
            });
        }

        // 📅 Filter berdasarkan range tanggal_keluar
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_keluar', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal_keluar', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal_keluar', '<=', $request->to);
        }

        // ✅ Urutkan berdasarkan waktu input terbaru
        $barangOut = $query->orderBy('created_at', 'desc')
                           ->orderBy('id', 'desc')
                           ->paginate(10);

        return view('barang_out.index', compact('barangOut'));
    }

    /**
     * Form tambah barang keluar
     */
    public function create(): View
    {
        $barang = Barang::all();
        return view('barang_out.create', compact('barang'));
    }

    /**
     * Simpan barang keluar
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        // Cari barang berdasarkan nama
        $barang = Barang::where('nama_barang', $request->nama_barang)->first();
        if (!$barang) {
            return back()->withErrors([
                'nama_barang' => 'Barang tidak ditemukan dalam stok!'
            ])->withInput();
        }

        // Cek stok cukup
        if ($barang->stok < $request->jumlah) {
            return back()->withErrors([
                'jumlah' => 'Stok tidak mencukupi!'
            ])->withInput();
        }

        // Simpan data barang keluar
        BarangOut::create([
            'barang_id'      => $barang->id,
            'nama_barang'    => $request->nama_barang,
            'jumlah'         => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        // Kurangi stok
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Catat log
        LogHistory::create([
            'user_id'       => Auth::id(),
            'aksi'          => 'Tambah Barang Keluar',
            'nama_barang'   => $request->nama_barang,
            'jumlah'        => $request->jumlah,
            'stok_sekarang' => $barang->stok,
        ]);

        return redirect()->route('barang_out.index')
                         ->with('success', 'Barang keluar berhasil ditambahkan!');
    }

    /**
     * Detail barang keluar
     */
    public function show(BarangOut $barangOut): View
    {
        return view('barang_out.show', compact('barangOut'));
    }

    /**
     * Form edit barang keluar
     */
    public function edit($id): View
    {
        $barangOut = BarangOut::findOrFail($id);
        return view('barang_out.edit', compact('barangOut'));
    }

    /**
     * Update barang keluar
     */
    public function update(Request $request, BarangOut $barangOut): RedirectResponse
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        // Cari barang lama
        $barang = Barang::where('nama_barang', $barangOut->nama_barang)->first();
        if (!$barang) {
            return back()->withErrors([
                'nama_barang' => 'Barang tidak ditemukan dalam stok!'
            ])->withInput();
        }

        // Kembalikan stok lama sebelum update
        $barang->stok += $barangOut->jumlah;

        // Cek stok cukup untuk update
        if ($barang->stok < $request->jumlah) {
            return back()->withErrors([
                'jumlah' => 'Stok tidak mencukupi untuk update!'
            ])->withInput();
        }

        // Update data barang_out
        $barangOut->update([
            'nama_barang'    => $request->nama_barang,
            'jumlah'         => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        // Kurangi stok sesuai jumlah baru
        $barang->stok -= $request->jumlah;
        $barang->save();

        // ✅ Catat log
        LogHistory::create([
            'user_id'       => Auth::id(),
            'aksi'          => 'Update Barang Keluar',
            'nama_barang'   => $request->nama_barang,
            'jumlah'        => $request->jumlah,
            'stok_sekarang' => $barang->stok,
            'waktu'         => now(),
        ]);

        return redirect()->route('barang_out.index')
                         ->with('success', 'Barang keluar berhasil diupdate!');
    }

    /**
     * Hapus barang keluar
     */
    public function destroy(BarangOut $barangOut): RedirectResponse
    {
        $barang = Barang::where('nama_barang', $barangOut->nama_barang)->first();

        if ($barang) {
            // Kembalikan stok saat data barang keluar dihapus
            $barang->stok += $barangOut->jumlah;
            $barang->save();
        }

        // ✅ Catat log
        LogHistory::create([
            'user_id'       => Auth::id(),
            'aksi'          => 'Hapus Barang Keluar',
            'nama_barang'   => $barangOut->nama_barang,
            'jumlah'        => $barangOut->jumlah,
            'stok_sekarang' => $barang ? $barang->stok : 0,
            'waktu'         => now(),
        ]);

        $barangOut->delete();

        return redirect()->route('barang_out.index')
                         ->with('success', 'Data barang keluar berhasil dihapus!');
    }
}
