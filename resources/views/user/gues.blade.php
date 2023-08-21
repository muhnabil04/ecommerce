@extends('layout.main')

@section('container')
    <h1 class="text-center mb-5 mt-3">Halaman Produk</h1>
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
                        <a href="{{ route('pesan.index', $hasil->id) }}" class="btn btn-primary"><i
                                class="fa fa-shopping-cart"></i>Pesan</a>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $produk->links() }}
    @endsection
