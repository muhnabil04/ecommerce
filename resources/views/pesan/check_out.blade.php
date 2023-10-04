@extends('layout.main')

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>checkout</h3>
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
                        @if (!empty($pesanan))
                            <div class="row mt-5">
                                <form action="{{ url('konfirmasi-checkout') }}" method="post">
                                    @csrf
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>no</th>
                                                <th>nama produk</th>
                                                <th>jumlah produk</th>
                                                <th>harga</th>
                                                <th>total harga</th>
                                                <th>aksi</th>
                                                <th>check box</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $nomor = 1;
                                            @endphp
                                            @foreach ($pesanan as $item)
                                                <tr>
                                                    <td>{{ $nomor++ }}</td>
                                                    <td>{{ $item->produk->nama }}</td>
                                                    <td>{{ $item->jumlah }}</td>
                                                    <td class="harga-cell">Rp. {{ $item->produk->harga }}</td>
                                                    <td>Rp. {{ number_format($item->jumlah_harga) }}</td>
                                                    <td>

                                                        <a href="{{ url('check-out/' . $item->id) }}"
                                                            class="btn btn-danger">hapus</a>

                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="item-checkbox"
                                                            data-price="{{ $item->jumlah_harga }}" name="selected_items[]"
                                                            value="{{ $item->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="5" align="right">Total Harga:</td>
                                                <td>Rp. <span id="total-harga">0.00</span></td>
                                                <td>
                                                    <input type="hidden" name="jumlah_harga" id="hidden-total-harga"
                                                        value="0">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-shopping-cart"></i> checkout
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        @else
                            <p class="text-center">Keranjang kosong</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const totalHargaElement = document.getElementById('total-harga');
        const hiddenTotalHargaElement = document.getElementById('hidden-total-harga');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                let totalHarga = 0;

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const itemPrice = parseFloat(checkbox.getAttribute('data-price'));
                        totalHarga += itemPrice;
                    }
                });

                totalHargaElement.textContent = `Rp. ${totalHarga.toFixed(2)}`;
                hiddenTotalHargaElement.value = totalHarga.toFixed(2);
            });
        });
    </script>
@endsection
