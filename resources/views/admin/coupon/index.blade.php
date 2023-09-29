@extends('admin.layout.navbar')
{{-- navbar --}}
@section('container')
    <h1 class="text-center mb-5 mt-3">Halaman {{ $title }}</h1>
    <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
    <table class="table table-bordered mt-5">

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif


        </div>
        <thead>
            <th>No</th>
            <th>kode</th>
            <th>diskon</th>
            <th>Aksi</th>
        </thead>

        @php
            // dd($produk[7]);
        @endphp

        <tbody>
            @php
                $nomor = 1 + ($coupon->currentPage() - 1) * $coupon->perPage();
                
            @endphp
            @foreach ($coupon as $no => $item)
                <tr>
                    <th>{{ $nomor++ }}</th>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->diskon }} %</td>
                    <td>
                        <form action="{{ route('admin.coupon.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('admin.coupon.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {{ $coupon->links() }}
@endsection
