@extends('layouts.app')

@section('content')
<div class="container text-center">

    <div class="d-flex align-items-center justify-content-center mb-5">
        <img src="{{ asset('logo-storeit.png') }}" alt="Logo" style="height: 50px;" class="me-3">
        <h2 href="/" style="color: #fff; fw-bold text-primary;">StoreIT</h2>
    </div>

    <div class="row justify-content-center">

        <div class="col-md-3">
            <a href="{{ url('/dashboard') }}" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 mb-4 menu-card">
                    <i class="bi bi-house-door-fill menu-icon"></i>
                    <h5 class="mt-3 text-dark">Dashboard</h5>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <div class="menu-wrapper">
                <div class="card shadow-lg border-0 p-4 mb-4 menu-card toggle-menu">
                    <i class="bi bi-box-seam-fill menu-icon"></i>
                    <h5 class="mt-3 text-dark">Inventory ▾</h5>
                </div>
                <div class="submenu">

                    {{-- Barang In & Out bisa diakses semua --}}
                    <a href="{{ url('/barang_in') }}" class="submenu-item">Barang In</a>
                    <a href="{{ url('/barang_out') }}" class="submenu-item">Barang Out</a>

                    {{-- Barang Master hanya muncul untuk admin --}}
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ url('/BarangMaster') }}" class="submenu-item">Barang Master</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="menu-wrapper">
                <div class="card shadow-lg border-0 p-4 mb-4 menu-card toggle-menu">
                    <i class="bi bi-file-earmark-bar-graph-fill menu-icon"></i>
                    <h5 class="mt-3 text-dark">Report ▾</h5>
                </div>
                <div class="submenu">
                    <a href="{{ url('/logactivity') }}" class="submenu-item">Log Activity</a>
                    <a href="{{ url('/log_history') }}" class="submenu-item">Log History</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body {
        background-color: #0a1d37;
    }
    .menu-card {
        background-color: #ffffff;
        border-radius: 15px;
        cursor: pointer;
        transition: 0.3s;
    }
    .menu-card:hover {
        transform: translateY(-8px);
        background-color: #ffffff;
    }
    .menu-icon {
        font-size: 3rem;
        color: #0a1d37;
    }
    .submenu {
        display: none;
        flex-direction: column;
        background: #fff;
        border-radius: 10px;
        margin-top: -15px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .submenu-item {
        padding: 10px;
        color: #0a1d37;
        text-decoration: none;
        font-weight: 500;
    }
    .submenu-item:hover {
        background: #f1f1f1;
    }
    .submenu.show {
        display: flex;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".toggle-menu").forEach(menu => {
            menu.addEventListener("click", function () {
                const submenu = this.nextElementSibling;
                submenu.classList.toggle("show");
            });
        });
    });
</script>
@endsection
