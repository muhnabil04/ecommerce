<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\produk;
use Symfony\Contracts\Service\Attribute\Required;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $coupon = Coupon::paginate(6);
        return view('admin.coupon.index')->with([
            'coupon' => $coupon,
            'title' => 'data coupon'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('admin.coupon.create')->with([
            'title' => 'data coupon',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'kode' => 'required',
            'diskon' => 'required'
        ]);

        $coupon = new Coupon;
        $coupon->kode = $request->kode;
        $coupon->diskon = $request->diskon;

        $coupon->save();

        return redirect()->route('admin.coupon.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit')->with([
            'coupon' => $coupon,
            'title' => 'coupon'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $coupon = Coupon::findOrFail($id);
        $request->validate([
            'kode' => 'required',
            'diskon' => 'required'
        ]);

        $coupon->kode = $request->kode;
        $coupon->diskon = $request->diskon;
        $coupon->save();

        return redirect()->route('admin.coupon.index')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return back()->with('succes', 'Data berhasil di hapus');
    }
}
