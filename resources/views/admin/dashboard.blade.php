@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="dash-header">
        <div class="text-center">
            <span class="dash-eyebrow">Overview</span>
            <h1 class="dash-title mb-1">Dashboard</h1>
            <p class="dash-subtitle mb-0">{{ now()->format('l, d F Y') }} &nbsp;•&nbsp; <span id="liveClock"></span></p>
        </div>
        <button type="button" class="btn btn-light btn-sm dash-refresh" id="btnRefresh" title="Muat Ulang">
            <i class="fas fa-sync-alt"></i>
        </button>
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

{{-- Kartu Statistik --}}
<div class="row">
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <a href="{{ route('barang_in.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon icon-primary"><i class="fas fa-cart-arrow-down"></i></div>
                <div class="stat-info">
                    <span class="stat-value" data-count="{{ $barangMasuk }}">0</span>
                    <span class="stat-label">Barang Masuk</span>
                    <span class="trend-badge {{ $masuk['diff'] >= 0 ? 'up' : 'down' }}">
                        <i class="fas fa-arrow-{{ $masuk['diff'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ $masuk['diff'] >= 0 ? '+' : '' }}{{ $masuk['pct'] }}%
                    </span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <a href="{{ route('barang_out.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon icon-danger"><i class="fas fa-truck-loading"></i></div>
                <div class="stat-info">
                    <span class="stat-value" data-count="{{ $barangKeluar }}">0</span>
                    <span class="stat-label">Barang Keluar</span>
                    <span class="trend-badge {{ $keluar['diff'] >= 0 ? 'up' : 'down' }}">
                        <i class="fas fa-arrow-{{ $keluar['diff'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ $keluar['diff'] >= 0 ? '+' : '' }}{{ $keluar['pct'] }}%
                    </span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <a href="{{ route('stock.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon icon-success"><i class="fas fa-boxes"></i></div>
                <div class="stat-info">
                    <span class="stat-value" data-count="{{ $totalStok }}">0</span>
                    <span class="stat-label">Total Stok</span>
                    <span class="stat-sub">keseluruhan unit</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <a href="{{ route('stock.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon icon-warning"><i class="fas fa-cube"></i></div>
                <div class="stat-info">
                    <span class="stat-value" data-count="{{ $jenisBarang }}">0</span>
                    <span class="stat-label">Jenis Barang</span>
                    <span class="stat-sub">kode terdaftar</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <a href="{{ route('log_activity.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon icon-info"><i class="fas fa-clipboard-list"></i></div>
                <div class="stat-info">
                    <span class="stat-value" data-count="{{ $logActivity }}">0</span>
                    <span class="stat-label">Log Activity</span>
                    <span class="stat-sub">seluruh transaksi</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <a href="{{ route('log_history.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon icon-secondary"><i class="fas fa-history"></i></div>
                <div class="stat-info">
                    <span class="stat-value" data-count="{{ $logHistory }}">0</span>
                    <span class="stat-label">Log History</span>
                    <span class="stat-sub">riwayat tersimpan</span>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Grafik --}}
<div class="row mt-1">
    <div class="col-lg-8 mb-3">
        <div class="card dash-card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h3 class="card-title mb-0 fs-5"><i class="fas fa-chart-bar me-2 text-primary"></i>Arus Barang 7 Hari Terakhir</h3>
                <div class="legend-dots">
                    <span class="dot dot-primary"></span> Masuk
                    <span class="dot dot-danger ms-3"></span> Keluar
                </div>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="flowChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card dash-card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h3 class="card-title mb-0 fs-5"><i class="fas fa-chart-pie me-2 text-primary"></i>Stok per Kategori</h3>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="kategoriChart"></canvas>
                </div>
                <div id="kategoriEmpty" class="text-center text-muted py-4 d-none">
                    <i class="fas fa-chart-pie fa-2x mb-2 d-block"></i>
                    Belum ada data kategori
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stok Menipis & Aktivitas Terbaru --}}
<div class="row mt-1">
    <div class="col-lg-4 mb-3">
        <div class="card dash-card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0 fs-5"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Stok Menipis</h3>
                <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-warning">Lihat Stok</a>
            </div>
            <div class="card-body">
                @forelse($lowStock as $item)
                    <div class="low-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="low-name text-truncate" title="{{ $item->nama_barang }}">{{ $item->nama_barang }}</span>
                            <span class="badge badge-pill {{ $item->stok <= 0 ? 'badge-danger' : 'badge-warning' }}">
                                {{ $item->stok }} pcs
                            </span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar {{ $item->stok <= 0 ? 'bg-danger' : 'bg-warning' }}"
                                 style="width: {{ ($item->stok > 10 ? 10 : $item->stok) * 10 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-success py-4">
                        <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                        <p class="mb-0">Semua stok barang dalam kondisi aman</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-3">
        <div class="card dash-card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0 fs-5"><i class="fas fa-bolt me-2 text-primary"></i>Aktivitas Terbaru</h3>
                <a href="{{ route('log_activity.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="card-body">
                @forelse($recentActivities as $act)
                    <div class="feed-item">
                        <span class="feed-avatar"><i class="fas fa-receipt"></i></span>
                        <div class="feed-content">
                            <div class="feed-text">{{ $act->activity ?? $act->Aktivitas }}
                                @if($act->module)<span class="feed-module">{{ $act->module }}</span>@endif
                            </div>
                            <div class="feed-time">
                                <i class="far fa-clock me-1"></i>{{ optional($act->created_at)->diffForHumans() ?? '-' }}
                                @if($act->user)<span class="mx-1">•</span>{{ $act->user }}@endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Belum ada aktivitas tercatat
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Stok Barang Terbaru --}}
<div class="card dash-card mt-1 border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0 fs-5"><i class="fas fa-boxes me-2 text-primary"></i>Stok Barang Terbaru</h3>
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
                                <span class="badge badge-pill
                                    {{ $item->stok <= 0 ? 'badge-danger' : ($item->stok <= 5 ? 'badge-warning' : 'badge-success') }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td class="align-middle text-muted">{{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}</td>
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
    .dash-header { position: relative; }
    .dash-refresh {
        position: absolute;
        top: .25rem;
        right: .5rem;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        box-shadow: 0 .15rem .4rem rgba(0, 0, 0, .05);
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
    .dash-tab i { font-size: .9rem; }
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
        gap: .9rem;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 1rem 1.1rem;
        height: 100%;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .55rem 1.1rem rgba(0, 0, 0, .08);
        border-color: #cfe2ff;
    }
    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(0, 0, 0, .06);
    }
    .stat-icon i { font-size: 1.1rem; }
    .icon-primary   { color: #007bff; background: rgba(0, 123, 255, .09); }
    .icon-danger    { color: #dc3545; background: rgba(220, 53, 69, .09); }
    .icon-success   { color: #28a745; background: rgba(40, 167, 69, .09); }
    .icon-warning   { color: #d39e00; background: rgba(255, 193, 7, .14); }
    .icon-info      { color: #17a2b8; background: rgba(23, 162, 184, .09); }
    .icon-secondary { color: #6c757d; background: rgba(108, 117, 125, .09); }
    .stat-info {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
        min-width: 0;
    }
    .stat-value {
        font-size: 1.45rem;
        font-weight: 700;
        color: #212529;
        font-variant-numeric: tabular-nums;
    }
    .stat-label {
        font-size: .8rem;
        font-weight: 600;
        color: #6c757d;
    }
    .stat-sub {
        font-size: .7rem;
        color: #adb5bd;
        margin-top: .1rem;
    }
    .trend-badge {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        margin-top: .25rem;
        font-size: .7rem;
        font-weight: 700;
        padding: .1rem .45rem;
        border-radius: 999px;
    }
    .trend-badge.up   { color: #1a7f37; background: rgba(25, 135, 84, .12); }
    .trend-badge.down { color: #b02a37; background: rgba(220, 53, 69, .12); }

    .dash-card { border-radius: 14px; }
    .dash-card .card-header { border-radius: 14px 14px 0 0; }
    .legend-dots {
        font-size: .8rem;
        color: #6c757d;
        font-weight: 500;
    }
    .dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: .3rem;
        vertical-align: middle;
    }
    .dot-primary { background: #007bff; }
    .dot-danger  { background: #dc3545; }
    .chart-wrap { position: relative; height: 270px; }

    .low-item .low-name {
        font-size: .85rem;
        font-weight: 600;
        color: #343a40;
        max-width: 60%;
    }
    .low-item .badge { font-size: .72rem; }

    .feed-item {
        display: flex;
        align-items: flex-start;
        gap: .8rem;
        padding: .65rem 0;
        border-bottom: 1px dashed #e9ecef;
    }
    .feed-item:last-child { border-bottom: 0; }
    .feed-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(0, 123, 255, .09);
        color: #007bff;
        border: 1px solid rgba(0, 123, 255, .18);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: .9rem;
    }
    .feed-content { min-width: 0; }
    .feed-text {
        font-size: .85rem;
        font-weight: 600;
        color: #212529;
    }
    .feed-module {
        display: inline-block;
        margin-left: .4rem;
        font-size: .65rem;
        font-weight: 600;
        color: #007bff;
        background: rgba(0, 123, 255, .1);
        padding: .05rem .4rem;
        border-radius: 999px;
        vertical-align: middle;
    }
    .feed-time {
        font-size: .75rem;
        color: #868e96;
    }
</style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        $(function () {
            // Jam digital
            function tickClock() {
                var now = new Date();
                $('#liveClock').text(now.toLocaleString('id-ID', {
                    weekday: 'long', day: '2-digit', month: 'long', year: 'numeric',
                    hour: '2-digit', minute: '2-digit', second: '2-digit'
                }));
            }
            tickClock();
            setInterval(tickClock, 1000);

            // Tombol muat ulang
            $('#btnRefresh').on('click', function () {
                $(this).find('i').addClass('fa-spin');
                window.location.reload();
            });

            // Animasi angka
            function countUp($el) {
                var target = parseFloat($el.data('count')) || 0;
                var duration = 1000;
                var start = performance.now();
                function tick(now) {
                    var p = Math.min((now - start) / duration, 1);
                    var val = Math.floor(target * (1 - Math.pow(1 - p, 3)));
                    $el.text(val.toLocaleString('id-ID'));
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            }
            $('[data-count]').each(function () { countUp($(this)); });

            // Grafik
            if (window.Chart) {
                var flowData = {
                    labels: @json($labels),
                    masuk: @json($masukData),
                    keluar: @json($keluarData)
                };

                var flowCtx = document.getElementById('flowChart');
                if (flowCtx) {
                    new Chart(flowCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: flowData.labels,
                            datasets: [{
                                label: 'Barang Masuk',
                                data: flowData.masuk,
                                backgroundColor: 'rgba(0, 123, 255, .8)',
                                borderColor: '#0062ff',
                                borderWidth: 1,
                                borderRadius: 4
                            }, {
                                label: 'Barang Keluar',
                                data: flowData.keluar,
                                backgroundColor: 'rgba(220, 53, 69, .65)',
                                borderColor: '#dc3545',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function (ctx) {
                                            return ctx.dataset.label + ': ' + ctx.parsed.y + ' transaksi';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 },
                                    grid: { color: 'rgba(0,0,0,.05)' }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 11 } }
                                }
                            }
                        }
                    });
                }

                var kategori = @json($stokPerKategori);
                var katKeys = Object.keys(kategori);
                if (katKeys.length) {
                    var palette = ['#007bff', '#dc3545', '#28a745', '#ffc107', '#17a2b8', '#6f42c1', '#fd7e14', '#6c757d'];
                    var katCtx = document.getElementById('kategoriChart');
                    if (katCtx) {
                        new Chart(katCtx.getContext('2d'), {
                            type: 'doughnut',
                            data: {
                                labels: katKeys,
                                datasets: [{
                                    data: katKeys.map(function (k) { return kategori[k]; }),
                                    backgroundColor: katKeys.map(function (_, i) { return palette[i % palette.length]; }),
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '62%',
                                plugins: {
                                    legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } },
                                    tooltip: {
                                        callbacks: {
                                            label: function (ctx) {
                                                var total = ctx.dataset.data.reduce(function (a, b) { return a + b; }, 0);
                                                var pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                                                return ' ' + ctx.label + ': ' + ctx.parsed + ' pcs (' + pct + '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                } else {
                    $('#kategoriEmpty').removeClass('d-none');
                }
            }
        });
    </script>
@stop