@extends('adminlte::page')

@section('content')
<div class="container">
    <h2>Daftar Barang</h2>

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">+ Tambah Barang</a>

     <form action="{{ route('barang.index') }}" method="GET" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Nama Barang</label>
                <input type="text" name="search" id="search"
                       class="form-control"
                       value="{{ request('search') }}"
                       placeholder="Masukkan nama barang...">
            </div>
            <div class="col-md-3">
                <label for="from" class="form-label">Dari Tanggal</label>
                <input type="date" name="from" id="from"
                       class="form-control"
                       value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <label for="to" class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" id="to"
                       class="form-control"
                       value="{{ request('to') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                {{--th>Kategori</th>--}}
                <th>Stok</th>
                <th>Waktu Ditambah</th>
                <th>Terakhir Diupdate</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $index => $b)
                <tr>
                    {{-- Nomor urut sesuai pagination --}}
                    <td>{{ $loop->iteration + ($barang->currentPage() - 1) * $barang->perPage() }}</td>
                    <td>{{ $b->Kode_Barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    {{--<td>{{ $b->kategori }}</td>--}}
                    <td>{{ $b->stok }}</td>
                    <td>{{ $b->created_at->timezone('Asia/Kuala_Lumpur')->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $b->updated_at->timezone('Asia/Kuala_Lumpur')->format('d-m-Y H:i:s') }}</td>
                    <td>
                        <a href="{{ route('barang.edit', $b->Id_Barang) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('barang.destroy', $b->Id_Barang) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus barang ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data barang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $barang->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
