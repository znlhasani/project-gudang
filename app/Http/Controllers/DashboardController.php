<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangIn;
use App\Models\BarangOut;
use App\Models\LogActivity;
use App\Models\LogHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $barangMasuk  = BarangIn::count();
        $barangKeluar = BarangOut::count();
        $logActivity  = LogActivity::withTrashed()->count();
        $logHistory   = LogHistory::count();
        $totalStok    = (int) Barang::sum('stok');
        $jenisBarang  = Barang::count();

        $stokBarang = Barang::orderBy('updated_at', 'desc')->take(5)->get();

        // Trend perbandingan hari ini vs kemarin
        $masuk  = $this->dailyTrend(BarangIn::class, 'created_at');
        $keluar = $this->dailyTrend(BarangOut::class, 'created_at');

        // Arus barang 7 hari terakhir
        $start = now()->subDays(6)->startOfDay();

        $masukPerHari = BarangIn::where('created_at', '>=', $start)
            ->get(['created_at'])
            ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'))
            ->map->count();

        $keluarPerHari = BarangOut::where('created_at', '>=', $start)
            ->get(['created_at'])
            ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'))
            ->map->count();

        $labels    = [];
        $masukData = [];
        $keluarData = [];

        for ($i = 6; $i >= 0; $i--) {
            $key = now()->subDays($i)->format('Y-m-d');
            $labels[]    = now()->subDays($i)->format('d/m');
            $masukData[] = $masukPerHari[$key] ?? 0;
            $keluarData[] = $keluarPerHari[$key] ?? 0;
        }

        // Stok per kategori
        $stokPerKategori = Barang::query()
            ->selectRaw('COALESCE("Kategori", \'Belum Dikategorikan\') as nama, COALESCE(SUM(stok), 0) as total')
            ->groupBy('nama')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($item) => [(string) $item->nama => (int) $item->total]);

        // Stok menipis
        $lowStock = Barang::where('stok', '<=', 5)->orderBy('stok')->take(5)->get();

        // Aktivitas terbaru
        $recentActivities = LogActivity::orderBy('created_at', 'desc')->take(6)->get();

        return view('admin.dashboard', compact(
            'barangMasuk', 'barangKeluar', 'logActivity', 'logHistory',
            'totalStok', 'jenisBarang', 'stokBarang',
            'labels', 'masukData', 'keluarData',
            'stokPerKategori', 'lowStock', 'recentActivities',
            'masuk', 'keluar'
        ));
    }

    private function dailyTrend(string $model, string $field): array
    {
        $today     = $model::whereDate($field, now()->today())->count();
        $yesterday = $model::whereDate($field, now()->subDay())->count();

        return [
            'today' => $today,
            'diff'  => $today - $yesterday,
            'pct'   => $yesterday > 0
                ? round(($today - $yesterday) / $yesterday * 100)
                : ($today > 0 ? 100 : 0),
        ];
    }
}
