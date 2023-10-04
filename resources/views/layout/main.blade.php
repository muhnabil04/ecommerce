<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />



    <title> {{ $title }} </title>
</head>
<style>
    footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 10px 0;
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .content {
        /* min-height: calc(100vh - 60px);
        /* Sesuaikan dengan tinggi navbar jika diperlukan */
        /* padding-bottom: 60px; */
        /* Sesuaikan dengan tinggi footer jika diperlukan */
        position: relative;
        */
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Auth::check())
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link {{ $title === 'dashboard' ? 'active' : '' }}" aria-current="page"
                            href="/dashboard">Home</a>
                        <a class="nav-link {{ $title === 'produk' ? 'active' : '' }}" href="/produk">produk</a>

                        @php
                            // Count the total notification count for main orders with status 0 (cart)
                            $totalNotif = \App\Models\Pesanan::where('user_id', Auth::user()->id)
                                ->where('status', 0)
                                ->with('details') // Assuming there's a relation named 'details'
                                ->count();
                        @endphp



                        <a class="nav-link me-3 {{ $title === 'keranjang' ? 'active' : '' }}"
                            href="{{ url('check-out') }}">
                            <i class="fa fa-shopping-cart"></i>
                            @if ($totalNotif > 0)
                                <span class="badge bg-danger text-white">{{ $totalNotif }}</span>
                            @endif
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li class="mb-1"> nama: {{ Auth::user()->name }}</li>
                                <li>saldo: Rp {{ number_format(Auth::user()->saldo) }} </a></li>
                                <li><a href="/riwayat"
                                        class="btn btn-outline-secondary shadow-sm d-sm d-block">riwayat</a></li>

                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="btn btn-outline-secondary shadow-sm d-sm d-block">
                                    Logout
                                </a>
                            @else
                                <div class="navbar-nav ms-auto">
                                    <a class="nav-link {{ $title === 'dashboard' ? 'active' : '' }}"
                                        aria-current="page" href="/dashboard">Home</a>
                                    <a class="nav-link {{ $title === 'produk' ? 'active' : '' }}"
                                        href="/produk">produk</a>


                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton1">
                                            <a href="{{ route('login') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="btn btn-outline-secondary shadow-sm d-sm d-block">
                                                Login
                                            </a>
                                        </ul>
                                    </div>
                                </div>

            @endif

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        </div>
        </div>
    </nav>
    {{-- @if (Auth::check())
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">BilShop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>

                        <li><a class="nav-link" href="/produk">Produk</a></li>
                    </ul>
                    <form class="d-flex">
                        <a href="{{ url('check-out') }}" class="btn btn-outline-dark" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">
                                @php
                                    $totalNotif = \App\Models\Pesanan::where('user_id', Auth::user()->id)
                                        ->where('status', 0)
                                        ->with('details')
                                        ->count();
                                @endphp
                                {{ $totalNotif }}
                            </span>
                        </a>
                    </form>
                    <a href="{{ route('logout') }}" class="btn btn-outline-secondary shadow-sm d-sm d-block">Logout</a>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">BilShop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>

                    <a href="{{ route('login') }}" class="btn btn-outline-secondary shadow-sm d-sm d-block">Login</a>
                </div>
            </div>
        </nav>
    @endif --}}


    {{-- <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Shop in style</h1>
                <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
            </div>
        </div>
    </header> --}}

    <div>
        @yield('container')
    </div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
