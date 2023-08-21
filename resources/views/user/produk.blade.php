@extends('layout.main')
{{-- navbar --}}
@section('container')
    <div class="input-group">
        <div class="form-outline" style="width: 200px">
            <input type="search" id="form1" class="form-control" />
            <label class="form-label" for="form1">Search</label>
        </div>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>
    <h1 class="text-center mb-5 mt-3">Halaman barang</h1>
    <table class="table table-bordered mt-5">
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($produk as $hasil)
                    <div class="card" style="width: 18rem; margin: 10px;">
                        <img src="{{ asset($hasil->foto) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hasil->nama }}</h5>
                            <p class="card-text">kategori: {{ $hasil->kategori }}</p>
                            <p class="card-text">deskripsi: {{ $hasil->deskripsi }}</p>
                            <p class="card-text">stok :{{ $hasil->stok }}</p>
                            <strong>RP {{ $hasil->harga }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $produk->links() }}



    </table>
@endsection
