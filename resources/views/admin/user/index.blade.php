@extends('admin.layout.navbar')
{{-- navbar --}}
@section('container')
    <h1 class="text-center mb-5 mt-3">Halaman {{ $title }}</h1>
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
            <th>saldo</th>
            <th>Aksi</th>
        </thead>

        @php
            // dd($produk[7]);
        @endphp

        <tbody>
            @php
                $nomor = 1 + ($user->currentPage() - 1) * $user->perPage();
                
            @endphp
            @foreach ($user as $no => $item)
                <tr>
                    <th>{{ $nomor++ }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->saldo }}</td>
                    <td>
                        <form action="{{ route('admin.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {{ $user->links() }}
@endsection
