@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center text-white p-3" style="background-color:#001f3f;">
        Daftar Barang
    </h2>

    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead style="background-color:#001f3f; color:#FFD700;">
                    <tr>
                        <th>No</th>
                        <th>Id Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $key => $b)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $b->Id_Barang }}</td>
                            <td>{{ $b->Kode_Barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->stok }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $b->Id_Barang) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('barang.destroy', $b->Id_Barang) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data barang belum tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
