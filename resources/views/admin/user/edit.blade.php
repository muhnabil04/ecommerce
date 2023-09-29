@extends('admin.layout.navbar')
@section('container')
    <div class="container mt-5">
        <form method="POST" action="{{ route('admin.user.update', $userData->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $userData->name }}">
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">saldo</label>
                <input type="text" class="form-control" id="name" name="saldo" value="{{ $userData->saldo }}">
            </div>
            <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
        </form>
    </div>
@endsection
