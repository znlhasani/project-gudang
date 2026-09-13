@extends('adminlte::page')

@section('content')
<div class="container">
    <h2>Daftar User</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('users.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ $keyword ?? '' }}" class="form-control me-2"
               placeholder="Cari nama atau email...">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->role === 'admin')
                        <span class="badge bg-success">Admin</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif
                </td>
                <td>
                    @if ($user->role !== 'admin')
                        <form action="{{ route('users.makeAdmin', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">Jadikan Admin</button>
                        </form>
                    @else
                        <form action="{{ route('users.makeUser', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Turunkan ke User</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
</div>
@endsection
