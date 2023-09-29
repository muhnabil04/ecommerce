@extends('admin.layout.navbar')

@section('container')
    <form method="POST" action="{{ route('admin.update', $produk->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $produk->nama }}">
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ $produk->kategori }}">
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $produk->deskripsi }}">
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">harga</label>
            <input type="text" class="form-control" id="harga" name="harga" value="{{ $produk->harga }}">
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="{{ $produk->stok }}">
        </div>
        <div class="form-group">
            <label>Foto:</label>
            <input type="file" name="foto">
        </div>
        <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
    </form>
@endsection
