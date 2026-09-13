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

        $barangMasuk   = BarangIn::count();
        $barangKeluar  = BarangOut::count();


        $logActivity   = LogActivity::withTrashed()->count();


        $logHistory    = LogHistory::count();


        $stokBarang    = Barang::orderBy('updated_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'barangMasuk',
            'barangKeluar',
            'logActivity',
            'logHistory',
            'stokBarang'
        ));
    }
}
