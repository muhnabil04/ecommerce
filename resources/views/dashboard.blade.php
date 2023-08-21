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
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur odit autem quod, adipisci
                        sunt
                        enim mollitia consectetur tenetur veritatis modi commodi incidunt ad expedita hic. Ratione sed
                        obcaecati deleniti asperiores.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
