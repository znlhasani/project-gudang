<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
       {
        return view('home', [
        'barang_in' => DB::table('barang_masuks')->count(),
        'barang_out' => DB::table('barang_keluars')->count(),
        'log_history' => DB::table('log_history')->count(),
        'log_activity' => DB::table('log_activity')->count(),
    ]);

    }
}
