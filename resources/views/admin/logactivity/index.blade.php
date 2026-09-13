@extends('adminlte::page')

@section('title', 'Log Activity')

@section('content_header')
    <h1 class="text-navy">📊 Log Activity</h1>
@stop

@section('content')
<div class="card shadow-lg border-0 rounded-3">
    <div class="card-body p-3">
        <table id="logTable" class="table table-hover table-bordered text-center align-middle">
            <thead class="table-header">
                <tr>
                    <th>Id Activity</th>
                    <th>Aktivitas</th>
                    <th>Detail</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Module</th>
                    <th>IP</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Id User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $log->Aktivitas ?? '-' }}</td>
                        <td>{{ $log->Detail ?? '-' }}</td>
                        <td>{{ $log->Waktu }}</td>
                        <td>{{ $log->user }}</td>
                        <td>{{ $log->activity }}</td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->updated_at }}</td>
                        <td>{{ $log->Id_User }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .text-navy {
            color: #1a237e;
            font-weight: 700;
        }
        .table-header {
            background-color: #1a237e;
            color: #fff;
        }
        #logTable tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        #logTable tbody tr:hover {
            background-color: #e3f2fd;
            transition: 0.2s;
        }
        #logTable_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 6px 10px;
        }
        #logTable_wrapper .dataTables_length select {
            border-radius: 8px;
            padding: 4px 8px;
        }
    </style>
@stop

@section('js')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#logTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                order: [[3, 'desc']], // default sort by Waktu
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "⏮️",
                        last: "⏭️",
                        next: "➡️",
                        previous: "⬅️"
                    }
                }
            });
        });
    </script>
@stop
