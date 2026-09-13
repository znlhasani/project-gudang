@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Barang Keluar</h2>
    <form action="{{ route('barang_out.update', $barangOut->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ $barangOut->nama_barang }}" required>
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $barangOut->jumlah }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_keluar">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" value="{{ $barangOut->tanggal_keluar }}" required>
        </div>

        <div class="form-group">
            <label for="kondisi_barang">Kondisi Barang</label>
            <select name="kondisi_barang" class="form-control" required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baru">Baru</option>
                <option value="Normal">Normal</option>
                <option value="Rusak">Rusak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('barang_out.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
