@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Barang Keluar</h3>

    <form action="{{ route('barang_in.update', $barangIn->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Barang --}}
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang"
                   class="form-control @error('nama_barang') is-invalid @enderror"
                   value="{{ old('nama_barang', $barangIn->nama_barang) }}">
            @error('nama_barang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah"
                   class="form-control @error('jumlah') is-invalid @enderror"
                   value="{{ old('jumlah', $barangIn->jumlah) }}">
            @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Masuk --}}
        <div class="mb-3">
            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                   class="form-control @error('tanggal_masuk') is-invalid @enderror"
                   value="{{ old('tanggal_masuk', $barangIn->tanggal_masuk) }}">
            @error('tanggal_masuk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kondisi Barang --}}
        <div class="mb-3">
            <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
            <select name="kondisi_barang" id="kondisi_barang"
                    class="form-control @error('kondisi_barang') is-invalid @enderror">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" {{ old('kondisi_barang', $barangIn->kondisi_barang) == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak" {{ old('kondisi_barang', $barangIn->kondisi_barang) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
            @error('kondisi_barang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('barang_in.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
