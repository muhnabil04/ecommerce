<?php

namespace App\Http\Controllers;

use App\models\produk;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        $produk = Produk::where('id', $id)->first();
        $tanggal = Carbon::now();

        if ($request->jumlah_pesan > $produk->stok) {
            return redirect('pesan/' . $id)->with('error', 'stok tidak cukup');
        }

        $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        if (empty($cek_pesanan)) {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->save();

            $pesanan_baru = $pesanan;
        } else {
            $pesanan_baru = $cek_pesanan;
        }

        $cek_pesanan_detail = PesananDetail::where('barang_id', $produk->id)
            ->where('pesanan_id', $pesanan_baru->id)
            ->first();

        if (empty($cek_pesanan_detail)) {
            $pesanan_detail = new PesananDetail;
            $pesanan_detail->barang_id = $produk->id;
            $pesanan_detail->pesanan_id = $pesanan_baru->id;
            $pesanan_detail->jumlah = $request->jumlah_pesan;
            $pesanan_detail->jumlah_harga = $produk->harga * $request->jumlah_pesan;
            $pesanan_detail->save();
        } else {
            $pesanan_detail = $cek_pesanan_detail;
            $pesanan_detail->jumlah = $pesanan_detail->jumlah + $request->jumlah_pesan;
            $pesanan_detail->jumlah_harga = $produk->harga * $pesanan_detail->jumlah;
            $pesanan_detail->update();
        }

        $pesanan_baru->jumlah_harga = $pesanan_baru->jumlah_harga + $produk->harga * $request->jumlah_pesan;
        $pesanan_baru->update();

        return redirect('pesan/' . $id)->with('success', 'pesanan anda sudah ada di keranjang');
    }


    public function check_out()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // Initialize an empty array to store pesanan_details if pesanan is not empty
        $pesanan_details = [];

        if (!empty($pesanan)) {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)
                ->with('produk')
                ->get();
        }

        return view('pesan.check_out', [
            'title' => 'Keranjang',
            'pesanan' => $pesanan,
            'pesanan_details' => $pesanan_details,
        ]);
    }





    public function delete($id)
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first();

        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();

        $pesanan->jumlah_harga = $pesanan->jumlah_harga - $pesanan_detail->jumlah_harga;

        $pesanan->update();

        $pesanan_detail->delete();

        return redirect('check-out')->with('error', 'pesanan berhasil di hapus');
    }

    public function konfirmasi(Request $request)
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)->where('status', 0)->first();

        $totalHarga = $pesanan->jumlah_harga;
        $pesanan_id = $pesanan->id;

        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();

        if ($user->saldo < $totalHarga) {
            return redirect('check-out')->with('error', 'Gagal, saldo Anda kurang. Hubungi admin untuk isi saldo, WhatsApp: 081234567');
        }

        foreach ($pesanan_details as $pesanan_detail) {
            $barang = Produk::findOrFail($pesanan_detail->barang_id);
            $barang->stok -= $pesanan_detail->jumlah;
            $barang->save();
        }

        $user->saldo -= $totalHarga;
        $user->save();

        $pesanan->status = 1;
        $pesanan->update();

        return redirect('dashboard')->with('success', 'Checkout berhasil. Kirim alamatmu ke admin, WhatsApp: 0812345678');
    }
}
