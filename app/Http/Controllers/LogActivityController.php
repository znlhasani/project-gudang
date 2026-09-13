<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function index()
    {
        // ambil data dari tabel log_activities
        $logs = LogActivity::orderBy('created_at', 'desc')->get();

        return view('report.logactivity', compact('logs'));
    }
}

