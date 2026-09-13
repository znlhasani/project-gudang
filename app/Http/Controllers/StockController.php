<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // ✅ Fitur search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Kode_Barang', 'like', "%$search%")
                  ->orWhere('nama_barang', 'like', "%$search%");
            });
        }

        // ✅ Sorting (default: DESC)
        $sort = $request->get('sort', 'desc');
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        // ✅ Ambil data stok dengan urutan sesuai pilihan
        $barang = $query->orderBy('Id_Barang', $sort)->paginate(10);

        // ✅ Kirim data ke view
        return view('Stock.index', compact('barang'));
    }
}
