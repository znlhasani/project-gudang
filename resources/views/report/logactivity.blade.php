@extends('adminlte::page')

@section('title', 'Log Activity')

@section('content_header')
    <div class="text-center">
        <span class="dash-eyebrow">Report</span>
        <h1 class="dash-title mb-1">Log Activity</h1>
        <p class="dash-subtitle mb-0">{{ now()->format('l, d F Y') }}</p>
    </div>
@stop

@section('content')
<div class="d-flex justify-content-center mb-4">
    <div class="dash-tabs">
        <a href="{{ route('dashboard') }}" class="dash-tab">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('barang_in.index') }}" class="dash-tab">
            <i class="fas fa-arrow-down"></i>
            <span>Barang Masuk</span>
        </a>
        <a href="{{ route('barang_out.index') }}" class="dash-tab">
            <i class="fas fa-arrow-up"></i>
            <span>Barang Keluar</span>
        </a>
        <a href="{{ route('stock.index') }}" class="dash-tab">
            <i class="fas fa-boxes"></i>
            <span>Stok</span>
        </a>
        <a href="{{ route('log_activity.index') }}" class="dash-tab active">
            <i class="fas fa-tasks"></i>
            <span>Log Activity</span>
        </a>
        <a href="{{ route('loghistory.index') }}" class="dash-tab">
            <i class="fas fa-history"></i>
            <span>Log History</span>
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0 fs-5 d-flex align-items-center gap-2"><i class="fas fa-tasks text-primary"></i>Data Log Activity</h3>
        <span class="badge badge-pill badge-primary badge-count">{{ $logs->count() }} data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="logTable" class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">ID Activity</th>
                        <th class="border-0">Aktivitas</th>
                        <th class="border-0">Detail</th>
                        <th class="border-0">Waktu</th>
                        <th class="border-0">User</th>
                        <th class="border-0">Activity</th>
                        <th class="border-0">Module</th>
                        <th class="border-0">IP</th>
                        <th class="border-0">Time</th>
                        <th class="border-0">Created At</th>
                        <th class="border-0">Updated At</th>
                        <th class="border-0">ID User</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->Id_Activity }}</td>
                        <td>{{ $log->Aktivitas }}</td>
                        <td>{{ $log->Detail }}</td>
                        <td>{{ $log->Waktu }}</td>
                        <td>{{ $log->user }}</td>
                        <td>{{ $log->activity }}</td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ $log->time }}</td>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->updated_at }}</td>
                        <td>{{ $log->Id_User }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .content-wrapper {
            background: linear-gradient(180deg, #e7f0ff 0%, #f3f8ff 50%, #f8fafc 100%) !important;
        }
        .content-header {
            background: transparent;
            padding-bottom: .5rem;
        }
        .dash-eyebrow {
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: .72rem;
            font-weight: 600;
            color: #007bff;
            background: rgba(0, 123, 255, .1);
            padding: .3rem .8rem;
            border-radius: 999px;
            margin-bottom: .5rem;
        }
        .dash-title {
            font-size: 1.9rem;
            font-weight: 700;
            color: #0a1d37;
        }
        .dash-subtitle {
            font-size: .85rem;
            color: #6c757d;
        }
        .dash-tabs {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: .45rem;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 999px;
            padding: .4rem;
            box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .04);
        }
        .dash-tab {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem 1.1rem;
            border-radius: 999px;
            font-size: .85rem;
            font-weight: 600;
            color: #6c757d;
            background: transparent;
            text-decoration: none;
            transition: background .18s ease, color .18s ease, box-shadow .18s ease;
        }
        .dash-tab i {
            font-size: .9rem;
        }
        .dash-tab:hover {
            color: #007bff;
            background: #f0f5ff;
            text-decoration: none;
        }
        .dash-tab.active {
            color: #fff;
            background: #007bff;
            box-shadow: 0 .25rem .6rem rgba(0, 123, 255, .3);
        }
        #logTable_wrapper .row {
            margin: 0;
        }
        #logTable_wrapper > .row {
            padding: .9rem 1.25rem 0;
        }
        #logTable_wrapper .dataTables_length,
        #logTable_wrapper .dataTables_filter {
            padding-bottom: .9rem;
        }
        #logTable_wrapper .dataTables_length label,
        #logTable_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-weight: 500;
            font-size: .85rem;
            color: #6c757d;
            margin: 0;
        }
        #logTable_wrapper .dataTables_length select {
            width: auto;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            padding: .3rem .6rem;
        }
        #logTable_wrapper .dataTables_filter input {
            width: 240px;
            border-radius: 999px;
            border: 1px solid #e9ecef;
            padding: .35rem .9rem;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        #logTable_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .12);
        }
        #logTable_wrapper .dataTables_info {
            color: #6c757d;
            font-size: .85rem;
            padding: 1rem 1.25rem;
        }
        #logTable_wrapper .dataTables_paginate {
            padding: .75rem 1.25rem 1rem 0;
        }
        #logTable_wrapper .dataTables_paginate .paginate_button {
            margin: 0 2px;
            border-radius: 8px !important;
        }
    .badge-count {
        font-size: .95rem;
        font-weight: 600;
        padding: .45rem .9rem;
        box-shadow: 0 .15rem .35rem rgba(0, 123, 255, .18);
    }
    </style>
@stop

@section('js')
    {{-- jQuery + DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function () {
            $('#logTable').DataTable({
                responsive: true,
                autoWidth: false,
                order: [[9, 'desc']],
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: ">",
                        previous: "<"
                    }
                }
            });
        });
    </script>
@stop