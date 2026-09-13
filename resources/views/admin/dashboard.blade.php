@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="text-center">
        <span class="dash-eyebrow">Overview</span>
        <h1 class="dash-title mb-1">Dashboard</h1>
        <p class="dash-subtitle mb-0">{{ now()->format('l, d F Y') }}</p>
    </div>
@stop

@section('content')
<div class="d-flex justify-content-center mb-4">
    <div class="dash-tabs">
        <a href="{{ route('dashboard') }}" class="dash-tab active">
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

<div class="row">
    <!-- Barang Masuk -->
    <div class="col-lg-3 col-sm-6 mb-3">
        <a href="{{ route('barang_in.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon text-primary">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $barangMasuk ?? 0 }}</span>
                    <span class="stat-label">Barang Masuk</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Barang Keluar -->
    <div class="col-lg-3 col-sm-6 mb-3">
        <a href="{{ route('barang_out.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon text-secondary">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value text-secondary">{{ $barangKeluar ?? 0 }}</span>
                    <span class="stat-label text-secondary">Barang Keluar</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Log Activity -->
    <div class="col-lg-3 col-sm-6 mb-3">
        <a href="{{ route('log_activity.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon text-info">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value text-info">{{ $logActivity ?? 0 }}</span>
                    <span class="stat-label text-info">Log Activity</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Log History -->
    <div class="col-lg-3 col-sm-6 mb-3">
        <a href="{{ route('log_history.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon text-dark">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value text-dark">{{ $logHistory ?? 0 }}</span>
                    <span class="stat-label text-dark">Log History</span>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Stok Barang Terbaru --}}
<div class="card mt-3 border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0 fs-5">Stok Barang Terbaru</h3>
        <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">No</th>
                        <th class="border-0">Kode Barang</th>
                        <th class="border-0">Nama Barang</th>
                        <th class="border-0 text-center">Stok</th>
                        <th class="border-0">Update Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stokBarang as $index => $item)
                        <tr>
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle"><span class="badge badge-pill badge-light">{{ $item->Kode_Barang }}</span></td>
                            <td class="align-middle">{{ $item->nama_barang }}</td>
                            <td class="align-middle text-center">
                                <span class="badge badge-pill {{ $item->stok > 0 ? 'badge-primary' : 'badge-danger' }}">{{ $item->stok }}</span>
                            </td>
                            <td class="align-middle text-muted">{{ $item->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data stok barang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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
    .stat-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        transition: all .2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .05);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon i {
        font-size: 1.25rem;
    }
    .text-primary .stat-icon  { background: rgba(0, 123, 255, .12); }
    .text-secondary .stat-icon{ background: rgba(108, 117, 125, .12); }
    .text-info .stat-icon     { background: rgba(23, 162, 184, .12); }
    .text-dark .stat-icon     { background: rgba(52, 58, 64, .12); }
    .stat-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: #343a40;
    }
    .stat-label {
        font-size: .85rem;
        font-weight: 500;
        color: #343a40;
    }
</style>
@stop