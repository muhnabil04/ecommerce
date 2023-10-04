@extends('layout.main')
{{-- navbar --}}
@section('container')
    <div class="container">
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
        <div class="row">
            <div class="col-md-6 mt-5">
                <div class="text">
                    <h1>SELAMAT DATANG</h1>
                    <p>Selamat Datang di BilShop - Tempat Terbaik untuk Berbelanja Online! Temukan berbagai produk
                        berkualitas dengan harga terbaik hanya di sini. Kami berkomitmen untuk memberikan pengalaman belanja
                        online yang mudah, aman, dan memuaskan. Jelajahi koleksi produk kami dan nikmati kemudahan
                        berbelanja dari rumah. Terima kasih telah memilih BilShop sebagai mitra belanja Anda. Selamat
                        berbelanja!</p>
                </div>
            </div>
            <div class="col-md-6 mt-n5">
                <img src="image/orang.png" alt="Gambar Orang" width="100%" />
            </div>
        </div>

    </div>
@endsection
