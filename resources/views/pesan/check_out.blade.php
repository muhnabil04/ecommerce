@extends('layout.main')
{{-- navbar --}}
@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>checkout</h3>
                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                    </div>

                    <div class="card-body">
                        @if (!empty($pesanan))
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>no</th>
                                            <th>nama produk</th>
                                            <th>jumlah produk</th>
                                            <th>harga</th>
                                            <th>total harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $nomor = 1;
                                    @endphp
                                    @foreach ($pesanan_details as $pesanan_detail)
                                        <tbody>
                                            <td>{{ $nomor++ }}</td>
                                            <td>
                                                {{ $pesanan_detail->produk->nama }}
                                            </td>
                                            <td>{{ $pesanan_detail->jumlah }}</td>
                                            <td>Rp. {{ $pesanan_detail->produk->harga }}</td>
                                            <td>Rp. {{ number_format($pesanan_detail->jumlah_harga) }}</td>
                                            <td>
                                                <form action="{{ url('check-out') }}/{{ $pesanan_detail->id }}"
                                                    method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" align="right">Total Harga:</td>
                                        <td>Rp. {{ number_format($pesanan->jumlah_harga) }}</td>
                                        <td>
                                            <form action="{{ url('konfirmasi-checkout') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="jumlah_harga"
                                                    value="{{ $pesanan->jumlah_harga }}">

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-shopping-cart">checkout</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>


                                </table>
                            @else
                                <p class="text-center">keranjang kosong</p>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
@endsection
