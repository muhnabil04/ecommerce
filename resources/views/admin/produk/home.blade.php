@extends('admin.layout.navbar')
{{-- navbar --}}
@section('container')
    <h1 class="text-center mb-5 mt-3">Halaman {{ $title }}</h1>
    <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
    <table class="table table-bordered mt-5">

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif


        </div>
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>kategori</th>
            <th>deskripsi</th>
            <th>harga</th>
            <th>stok</th>
            <th>foto</th>
            <th>Aksi</th>
        </thead>

        @php
            // dd($produk[7]);
        @endphp

        <tbody>
            @php
                $nomor = 1 + ($produk->currentPage() - 1) * $produk->perPage();
                
            @endphp
            @foreach ($produk as $no => $hasil)
                <tr>
                    <th>{{ $nomor++ }}</th>
                    <td>{{ $hasil->nama }}</td>
                    <td>{{ $hasil->kategori }}</td>
                    <td>{{ $hasil->deskripsi }}</td>
                    <td>{{ $hasil->harga }}</td>
                    <td>{{ $hasil->stok }}</td>
                    <td><img src="{{ asset($hasil->foto) }}" alt="Product Photo" width="100"></td>
                    <td>
                        <form action="{{ route('admin.destroy', $hasil->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('admin.edit', $hasil->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {{ $produk->links() }}
@endsection
