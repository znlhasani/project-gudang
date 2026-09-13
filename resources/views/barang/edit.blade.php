@extends('adminlte::page')

@section('content')
<div class="container">
    <h2 class="mb-4 text-white p-3" style="background-color:#001f3f;">
        Edit Barang
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
            <form action="{{ route('barang.update', $barang->Id_Barang) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    {{-- readonly supaya bisa tampil dan ikut submit --}}
                    <input
                        id="kode_barang"
                        name="kode_barang"
                        type="text"
                        class="form-control"
                        value="{{ old('kode_barang', $barang->Kode_Barang) }}"
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang', $barang->Nama_Barang) }}" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok"
                           class="form-control"
                           value="{{ old('stok', $barang->Stok) }}" min="0" required>
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


                <button type="submit" class="btn" style="background-color:#001f3f; color:#FFD700;">Update</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
