@extends('layout.main')

@section('container')
    <h1>Riwayat Pesanan</h1>
    <a href="{{ route('excel') }}" class="btn btn-success col-md-1 mb-2"><i class="fas fa-file-excel">
            Excel</i></a>
    <div class="card">
        <table class="table-bordered" style="text-align:center;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th> jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $nomor = 1 + ($pesanan->currentPage() - 1) * $pesanan->perPage();
                @endphp
                @foreach ($pesanan as $pesan)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $pesan->produk->nama }}</td>
                        <td>{{ $pesan->produk->harga }}</td>
                        <td>{{ $pesan->jumlah }}</td>
                        <td>{{ $pesan->jumlah_harga }}</td>
                        <td>{{ $pesan->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <br>
        {{ $pesanan->links() }}
    </div>
@endsection
