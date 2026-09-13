<?php

namespace App\Http\Controllers;

use App\Models\LogHistory;
use Illuminate\Http\Request;

class LogHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LogHistory::query();

        // 🔎 Filter keyword
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('aksi', 'like', '%' . $request->search . '%')
                ->orWhere('nama_barang', 'like', '%' . $request->search . '%')
                ->orWhere('user_id', 'like', '%' . $request->search . '%');
            });
        }

        // 📅 Filter range tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        }

        // Urutkan log terbaru (NULL terakhir)
        $logs = $query->orderByRaw('created_at IS NULL')
                      ->orderBy('created_at', 'desc')
                      ->orderBy('id', 'desc')
                      ->paginate(10);

        return view('loghistory.index', compact('logs'));
    }

}
