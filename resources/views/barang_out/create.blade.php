@extends('adminlte::page')

@section('title', 'Tambah Barang Keluar')

@section('content_header')
    <div class="text-center">
        <span class="dash-eyebrow">Inventory</span>
        <h1 class="dash-title mb-1">Tambah Barang Keluar</h1>
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
        <a href="{{ route('barang_out.index') }}" class="dash-tab active">
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

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h3 class="card-title mb-0 fs-5 d-flex align-items-center gap-2"><i class="fas fa-arrow-up text-secondary"></i>Form Barang Keluar</h3>
            </div>
            <div class="card-body">
                {{-- Pesan error kalau ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('barang_out.store') }}" method="POST">
                    @csrf

                    {{-- Pilih barang dari stok --}}
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <select name="nama_barang" id="nama_barang"
                                class="form-control js-tom-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->nama_barang }}" {{ old('nama_barang') == $b->nama_barang ? 'selected' : '' }}>
                                    {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah keluar --}}
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Keluar</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                               value="{{ old('jumlah') }}" min="1" required>
                    </div>

                    {{-- Tanggal keluar --}}
                    <div class="mb-3">
                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control"
                               value="{{ old('tanggal_keluar') }}" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('barang_out.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
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
</style>
@stop

@push('scripts')
<script>
    new TomSelect(".js-tom-select", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "-- Pilih --"
    });
</script>
@endpush