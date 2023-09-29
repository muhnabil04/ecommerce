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
                                                        <label for="coupon">Coupon Code:</label>
                                                        <input type="text" id="coupon" name="coupon_code"
                                                            class="form-control">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary mt-4">
                                                        <i class="fa fa-shopping-cart"></i> masukan keranjang
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
