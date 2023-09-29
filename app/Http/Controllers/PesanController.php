<?php

namespace App\Http\Controllers;

use App\models\produk;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Coupon;
use App\Models\PesananDetail;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\database\Eloquent\Model;
use App\Models\User;
use App\Exports\RiwayatExport;
use Maatwebsite\Excel\Facades\Excel;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {

        $produk = produk::where('id', $id)->first();

        return view('pesan.index', [
            'title' => 'pesan', // Here was the syntax error
            'produk' => $produk,
        ]);
    }

    public function pesan(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $user = Auth::user();
        $tanggal = Carbon::now();

        if ($request->jumlah_pesan > $produk->stok) {
            return redirect('pesan/' . $id)->with('error', 'Stok tidak cukup');
        }

        $couponCode = $request->input('coupon_code');
        $couponDiscount = 0;

        $coupon = Coupon::where('kode', $couponCode)->first();

        if ($coupon) {
            $couponDiscount = $coupon->diskon;
        }


        $jumlahPesan = $request->jumlah_pesan;

        $hargaSetelahDiskon = $produk->harga * (1 - ($couponDiscount / 100));

        $cek_pesanan = Pesanan::where('user_id', $user->id)
            ->where('produk_id', $produk->id)
            ->where('status', 0)
            ->first();

        if (!$cek_pesanan) {
            $pesanan = new Pesanan;
            $pesanan->produk_id = $produk->id;
            $pesanan->user_id = $user->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->jumlah = $jumlahPesan;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = $hargaSetelahDiskon * $jumlahPesan;
            $pesanan->save();

            return redirect('pesan/' . $id)->with('success', 'Pesanan anda sudah ada di keranjang');
        } else {
            $cek_pesanan->jumlah_harga += $hargaSetelahDiskon * $jumlahPesan;
            $cek_pesanan->jumlah += $jumlahPesan;
            $cek_pesanan->update();

            return redirect('pesan/' . $id)->with('success', 'Code coupon telah digunakan. Anda mendapat potongan harga ' . $couponDiscount . '%');
        }
    }







    public function check_out()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->get();


        $totalHarga = 0;

        foreach ($pesanan as $item) {
            $totalHarga +=  $item['jumlah_harga'];
        }

        // dd($totalHarga);  
        return view('pesan.check_out', [
            'title' => 'Keranjang',
            'pesanan' => $pesanan,
            'totalHarga' => $totalHarga,
        ]);
    }





    public function delete($id)
    {
        $pesanan_detail = Pesanan::findOrFail($id);



        // $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();

        // $pesanan->jumlah_harga = $pesanan->jumlah_harga - $pesanan_detail->jumlah_harga;

        // $pesanan->update();

        $pesanan_detail->delete();

        return redirect('check-out')->with('error', 'pesanan berhasil di hapus');
    }

    public function konfirmasi(Request $request)
    {
        $user = Auth::user();
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect('check-out')->with('error', 'Pilih salah satu produk');
        }

        $pesanan = Pesanan::where('user_id', $user->id)
            ->whereIn('id', $selectedItems)
            ->where('status', 0)
            ->get();

        if ($pesanan->isEmpty()) {
            return redirect('check-out')->with('error', 'Kosong');
        }

        $totalHarga = 0;

        foreach ($pesanan as $item) {
            $totalHarga += $item->jumlah_harga;
        }

        if ($user->saldo < $totalHarga) {
            return redirect('check-out')->with('error', 'Gagal, saldo Anda kurang. Hubungi admin untuk isi saldo, WhatsApp: 081234567');
        }

        foreach ($pesanan as $item) {
            $barang = $item->produk;
            if ($barang->stok < $item->jumlah) {
                return redirect('check-out')->with('error', 'Gagal, stok produk ' . $barang->nama . ' tidak mencukupi.');
            }

            $barang->stok -= $item->jumlah;
            $barang->save();

            $item->status = 1;
            $item->save();
        }

        $user->saldo -= $totalHarga;
        $user->save();

        return redirect('dashboard')->with('success', 'Checkout berhasil. Kirim alamatmu ke admin, WhatsApp: 0812345678');
    }








    public function riwayat()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->with('produk')
            ->paginate(10);

        return view('riwayat', [
            'pesanan' => $pesanan,
            'title' => 'Riwayat Pesanan'
        ]);
    }

    public function downloadRiwayatExcel()
    {
        $data = [];

        $pesanan = Pesanan::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->with(['produk'])
            ->get();

        foreach ($pesanan as $item) {

            $data[] = [
                'produk_nama' => $item->produk->nama,
                'produk_harga' => $item->produk->harga,
                'jumlah' => $item->jumlah,
                'jumlah_harga' => $item->jumlah_harga,
                'created_at' => $item->created_at,
            ];
        }

        return Excel::download(new RiwayatExport($data), 'riwayat_pesanan.xlsx');
    }
}
