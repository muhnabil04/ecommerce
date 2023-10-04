@extends('layout.main')
{{-- navbar --}}

@section('container')
    {{-- <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">BilShop</h1>
                <p class="lead fw-normal text-white-50 mb-0">Menyediakan Produk Terbaik untuk Anda</p>
            </div>
        </div>
    </header> --}}
    <div class="container mt-4">
        <form action="/produk" method="GET">
            <div class="input-group rounded position-right" style=" width: 300px; ">
                <input type="search" class="form-control rounded " placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" name="search" />
                <button class="input-group-text border-0" id="search-addon" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 ">
                    <div class="col mb-5">
                        <div class="card h-100">
                            @foreach ($produk as $item)
                                <!-- Sale badge-->
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                                    Sale
                                </div>
                                <!-- Product image-->
                                <img class="card-img-top" src="{{ asset($item->foto) }}" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">

                                        <h5 class="fw-bolder">{{ $item->nama }}</h5>

                                        <p class="card-text">Category: {{ $item->kategori }}</p>

                                        <p class="card-text">Description: {{ $item->deskripsi }}</p>

                                        <p class="card-text">Stok: {{ $item->stok }}</p>
                                        <p class="card-text"><strong>Price: RP {{ $item->harga }}</strong></p>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                            href="{{ route('pesan.index', $item->id) }}"> <i
                                                class="bi-cart-fill me-1"></i>Tambah ke keranjang</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
