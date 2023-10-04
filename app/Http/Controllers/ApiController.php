<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\coupon;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PhpParser\Node\Stmt\TryCatch;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function produk()
    {

        try {
            $dataProduk = produk::paginate(6);
            if (empty($dataProduk)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found',
                    "data" => null,
                ], 404);
            } else {
                return response()->json(
                    [
                        'produk' =>
                        $dataProduk
                    ]
                );
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function pesan(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'authentikasi salah',
            ], 401);
        }

        $produk = Produk::findOrFail($id);

        if ($request->jumlah_pesan > $produk->stok) {
            return response()->json(['error' => 'Stok tidak cukup'], 400);
        }

        $couponCode = $request->input('coupon_code');
        $couponDiscount = 0;

        $coupon = Coupon::where('kode', $couponCode)->first();

        if ($coupon) {
            $couponDiscount = $coupon->diskon;
        }


        $jumlahPesan = $request->jumlah_pesan;
        $hargaSetelahDiskon = $produk->harga * (1 - ($couponDiscount / 100));
        $totalHarga = $hargaSetelahDiskon * $jumlahPesan;


        $cek_pesanan = Pesanan::where('user_id', $user->id)
            ->where('produk_id', $produk->id)
            ->where('status', 0)
            ->first();

        if (!$cek_pesanan) {
            $pesanan = new Pesanan;
            $pesanan->produk_id = $produk->id;
            $pesanan->user_id = $user->id;
            $pesanan->tanggal = Carbon::now();
            $pesanan->jumlah = $jumlahPesan;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = $totalHarga;
            $pesanan->save();


            return response()->json(['success' => 'Pesanan anda sudah ada di keranjang', 'pesanan' => $pesanan]);
        } else {
            $cek_pesanan->jumlah_harga += $totalHarga;
            $cek_pesanan->jumlah += $jumlahPesan;
            $cek_pesanan->update();

            return response()->json(['success' => 'Code coupon telah digunakan. Anda mendapat potongan harga ' . $couponDiscount . '%', 'pesanan' => $cek_pesanan]);
        }
    }

    public function konfirmasi(Request $request)
    {
        $user = Auth::user();

        $pesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 0)
            ->get();

        if ($pesanan->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada pesanan yang harus dikonfirmasi.'
            ], 400);
        }

        $totalHarga = 0;

        foreach ($pesanan as $item) {
            $totalHarga += $item->jumlah_harga;
        }

        if ($user->saldo < $totalHarga) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal, saldo Anda kurang. Hubungi admin untuk isi saldo, WhatsApp: 081234567.'
            ], 400);
        }


        foreach ($pesanan as $item) {
            $barang = $item->produk;

            if ($barang->stok < $item->jumlah) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal, stok produk ' . $barang->nama . ' tidak mencukupi.'
                ], 400);
            }

            $barang->stok -= $item->jumlah;
            $barang->save();

            $item->status = 1;
            $item->save();
        }

        $user->saldo -= $totalHarga;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout berhasil. Kirim alamatmu ke admin, WhatsApp: 0812345678.'
        ], 200);
    }

    public function keranjang()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;

            $pesanan = Pesanan::where('user_id', $user_id)->where('status', 0)->get();

            $totalHarga = 0;

            foreach ($pesanan as $item) {
                $totalHarga += $item['jumlah_harga'];
            }

            return response()->json([
                'pesanan' => $pesanan,
                'totalHarga' => $totalHarga,
            ], 200);
        } else {
            return response()->json([
                'error' => 'kamu belum login',
            ], 401);
        }
    }

    public function profile()
    {
        try {
            $user_id = Auth::user();
            return response()->json([
                'user' => $user_id
            ]);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getUser($id)
    {
        $user = Auth::user();

        try {
            if ($user->role_id === 1) {

                $user_id = user::findOrFail($id);

                if ($user_id) {
                    return response()->json([
                        'status' => 'success',
                        'data' => $user_id
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'user not found'
                    ], 404);
                }
            } elseif ($user->role_id === 2) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'anda tidak punya akses'
                ], 401);
            }
        } catch (Exception $e) {
            return $e;
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
