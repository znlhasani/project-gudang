@extends('adminlte::page')

@section('content')
<div class="container my-5 text-center">
    <h2 class="fw-bold mb-4">About Us</h2>

    <p class="mb-4">
        Kami adalah tim pengembang aplikasi manajemen gudang yang bertujuan
        mempermudah pencatatan barang masuk dan keluar dengan sistem berbasis web.
    </p>

    <!-- Tambahkan gambar -->
    <img src="{{ asset('images/foto-kita.png') }}"
         alt="Our Team"
         class="img-fluid rounded shadow">
</div>

@endsection
