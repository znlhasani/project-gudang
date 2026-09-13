@extends('adminlte::page')

@section('title', 'Barang Masuk')

@section('content_header')
    <div class="text-center">
        <span class="dash-eyebrow">Inventory</span>
        <h1 class="dash-title mb-1">Barang Masuk</h1>
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
        <a href="{{ route('barang_in.index') }}" class="dash-tab active">
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
        <a href="{{ route('log_activity.index') }}" class="dash-tab">
            <i class="fas fa-tasks"></i>
            <span>Log Activity</span>
        </a>
        <a href="{{ route('loghistory.index') }}" class="dash-tab">
            <i class="fas fa-history"></i>
            <span>Log History</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h3 class="card-title mb-0 fs-5"><i class="fas fa-filter me-2 text-primary"></i>Filter</h3>
        <a href="{{ route('barang_in.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Barang Masuk
        </a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('barang_in.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Barang / Jumlah</label>
                    <input type="text" id="search" name="search" class="form-control"
                           placeholder="Cari disini"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                           value="{{ request('start_date') }}">
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" class="form-control"
                           value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2 text-md-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('barang_in.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3 border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0 fs-5"><i class="fas fa-arrow-down me-2 text-primary"></i>Riwayat Barang Masuk</h3>
        <span class="badge badge-pill badge-primary badge-count">{{ $barangIn->total() }} data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">No</th>
                        <th class="border-0">Nama Barang</th>
                        <th class="border-0 text-center">Jumlah</th>
                        <th class="border-0">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangIn as $index => $item)
                    <tr>
                        <td class="align-middle">{{ $barangIn->firstItem() + $index }}</td>
                        <td class="align-middle">{{ $item->nama_barang }}</td>
                        <td class="align-middle text-center">
                            <span class="badge badge-pill badge-primary">{{ $item->jumlah }}</span>
                        </td>
                        <td class="align-middle">
                            <span class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</span>
                            <small class="d-block text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada data barang masuk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($barangIn->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-center mb-0">
            {{ $barangIn->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>
@stop

@section('css')
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
.badge-count {
        font-size: .95rem;
        font-weight: 600;
        padding: .45rem .9rem;
        box-shadow: 0 .15rem .35rem rgba(0, 123, 255, .18);
    }
</style>
@stop