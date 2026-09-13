{{-- Override: Floating Centered Menu Hub (replaces left sidebar) --}}

<style>
    .main-header.navbar,
    .content-wrapper,
    .main-footer {
        margin-left: 0 !important;
    }
    .main-sidebar {
        display: none !important;
    }
    body.sidebar-mini .content-wrapper {
        margin-left: 0 !important;
    }

    .menu-hub-fab {
        position: fixed;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        background: #007bff;
        color: #fff;
        font-size: 1.4rem;
        box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .35);
        z-index: 1050;
        transition: transform .2s ease, background .2s ease;
    }
    .menu-hub-fab:hover {
        background: #0069d9;
        transform: translateX(-50%) scale(1.08);
    }

    .menu-hub-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(10, 29, 55, .45);
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease;
        z-index: 1040;
    }
    .menu-hub-backdrop.show {
        opacity: 1;
        visibility: visible;
    }

    .menu-hub {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(.96);
        width: min(640px, calc(100vw - 2rem));
        max-height: calc(100vh - 4rem);
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, .2);
        opacity: 0;
        visibility: hidden;
        transition: transform .25s ease, opacity .25s ease;
        z-index: 1045;
        overflow: hidden;
    }
    .menu-hub.show {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }

    .menu-hub-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e9ecef;
        background: #f8fbff;
    }
    .menu-hub-title {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-weight: 700;
        font-size: 1.05rem;
        color: #0a1d37;
    }
    .menu-hub-close {
        border: none;
        background: #eef3ff;
        color: #0a1d37;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s ease;
    }
    .menu-hub-close:hover {
        background: #dbe7ff;
    }

    .menu-hub-body {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .menu-hub .nav-sidebar {
        flex-wrap: wrap;
    }
    .menu-hub .nav-sidebar > .nav-item {
        flex-basis: 100%;
    }
    .menu-hub .nav-sidebar .nav-link {
        display: flex;
        align-items: center;
        gap: .75rem;
        color: #343a40;
        border-radius: 10px;
        padding: .65rem .9rem;
        margin-bottom: .2rem;
        font-size: .95rem;
        transition: background .15s ease, color .15s ease;
    }
    .menu-hub .nav-sidebar .nav-link:hover {
        background: #eef3ff;
        color: #0069d9;
    }
    .menu-hub .nav-sidebar .nav-link.active {
        background: #007bff;
        color: #fff;
    }
    .menu-hub .nav-sidebar .nav-link .nav-icon {
        color: #007bff;
    }
    .menu-hub .nav-sidebar .nav-link.active .nav-icon {
        color: #fff;
    }
    .menu-hub .nav-sidebar .nav-arrow {
        margin-left: auto;
    }
    .menu-hub .nav-sidebar .nav-header {
        font-size: .7rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #6c757d;
        padding: .65rem .5rem .25rem;
    }
    .menu-hub .nav-sidebar .nav-treeview .nav-link {
        padding-left: 2.25rem;
        font-size: .88rem;
    }
</style>

{{-- Floating toggle button --}}
<button type="button" class="menu-hub-fab" id="menu-hub-fab" aria-label="Menu">
    <i class="fas fa-bars"></i>
</button>

{{-- Backdrop --}}
<div class="menu-hub-backdrop" id="menu-hub-backdrop"></div>

{{-- Floating centered menu hub --}}
<div class="menu-hub" id="menu-hub">
    <div class="menu-hub-header">
        <div class="menu-hub-title">
            <img src="{{ asset('logo-storeit.png') }}" alt="Logo" style="height: 32px;">
            <span>Navigasi Menu</span>
        </div>
        <button type="button" class="menu-hub-close" id="menu-hub-close" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="menu-hub-body">
        <ul class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview" role="menu"
            data-animation-speed="300">
            @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var hub = document.getElementById('menu-hub');
        var backdrop = document.getElementById('menu-hub-backdrop');
        var fab = document.getElementById('menu-hub-fab');
        var closeBtn = document.getElementById('menu-hub-close');
        var navbarToggler = document.getElementById('menu-hub-toggler');

        function openHub() {
            hub.classList.add('show');
            backdrop.classList.add('show');
        }
        function closeHub() {
            hub.classList.remove('show');
            backdrop.classList.remove('show');
        }

        fab.addEventListener('click', function () {
            hub.classList.contains('show') ? closeHub() : openHub();
        });
        closeBtn.addEventListener('click', closeHub);
        backdrop.addEventListener('click', closeHub);
        if (navbarToggler) {
            navbarToggler.addEventListener('click', function (e) {
                e.preventDefault();
                hub.classList.contains('show') ? closeHub() : openHub();
            });
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeHub();
        });
    });
</script>