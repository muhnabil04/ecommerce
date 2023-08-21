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

    <title> {{ $title }} </title>
</head>

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
                            $pesanan_utama = \App\Models\Pesanan::where('user_id', Auth::user()->id)
                                ->where('status', 0)
                                ->first();
                            
                            $notif = 0;
                            if ($pesanan_utama) {
                                $notif = \App\Models\PesananDetail::where('pesanan_id', $pesanan_utama->id)->count();
                            }
                        @endphp

                        <a class="nav-link me-3 {{ $title === 'keranjang' ? 'active' : '' }}"
                            href="{{ url('check-out') }}">
                            <i class="fa fa-shopping-cart"></i>
                            @if ($notif > 0)
                                <span class="badge bg-danger text-white">{{ $notif }}</span>
                            @endif
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li class="mb-1"> nama: {{ Auth::user()->name }}</li>
                                <li>saldo: Rp {{ number_format(Auth::user()->saldo) }} </a></li>
                                <li class="mt-1`">

                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="btn btn-outline-secondary shadow-sm d-sm d-block">
                                        Logout
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="btn btn-outline-secondary shadow-sm d-sm d-block">
                                        Login
                                    </a>
            @endif
            </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        </div>
        </div>
        </div>
    </nav>

    <div class="container mt-4">
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
