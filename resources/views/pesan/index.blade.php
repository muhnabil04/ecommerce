@extends('layout.main')
{{-- navbar --}}
@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset($produk->foto) }}" width="100%">
                            </div>

                            <div class="col-md-6 mt-5">
                                <h3>{{ $produk->nama }}</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>kategori</td>
                                            <td>:</td>
                                            <td>{{ $produk->kategori }}</td>
                                        </tr>

                                        <tr>
                                            <td>deskripsi</td>
                                            <td>:</td>
                                            <td> {{ $produk->deskripsi }}</td>
                                        </tr>
                                        <tr>
                                            <td>stok</td>
                                            <td>:</td>
                                            <td> {{ number_format($produk->stok) }}</td>
                                        </tr>
                                        <tr>
                                            <td>harga</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($produk->harga) }}</td>
                                        </tr>
                                        <tr>

                                            <td>jumlah pesan</td>
                                            <td>:</td>
                                            <td>
                                                <form action="{{ url('pesan', $produk->id) }}" method="POST">
                                                    @csrf
                                                    <input type="number" name="jumlah_pesan" class="form-control" required>

                                                    <div class="form-group mt-3">
                                                        <label for="coupon">Coupon Code (optional):</label>
                                                        <input type="text" id="coupon" name="coupon_code"
                                                            class="form-control">
                                                    </div>

                                                    <button class="btn btn-outline-dark flex-shrink-0 mt-3" type="submit">
                                                        <i class="bi bi-cart-fill me-1"></i>
                                                        Masukkan ke Keranjang
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <section class="py-5 bg-light">
                        <div class="container px-4 px-lg-5 mt-5">
                            <h2 class="fw-bolder mb-4">Rekomendasi produk</h2>
                            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 ">
                                <div class="col mb-5">
                                    <div class="card h-100">
                                        @foreach ($produks as $item)
                                            <!-- Sale badge-->
                                            <div class="badge bg-dark text-white position-absolute"
                                                style="top: 0.5rem; right: 0.5rem">
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

            </div>
        </div>
    @endsection
