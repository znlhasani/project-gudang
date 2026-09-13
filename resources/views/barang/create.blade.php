@extends('adminlte::page')

@section('content')
<div class="container">
    <h2 class="mb-4 text-white p-3" style="background-color:#001f3f;">
        Tambah Barang
    </h2>

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kode_barang">Kode Barang</label>
                     <input type="text" name="kode_barang" value="{{ $kodeBarang }}" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                </div>

                {{--<div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Konsumsi">Konsumsi</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>--}}

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" min="0" required>
                </div>


                <button type="submit" class="btn" style="background-color:#001f3f; color:#FFD700;">Simpan</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
