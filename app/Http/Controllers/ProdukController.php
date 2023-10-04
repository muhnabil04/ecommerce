<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {

        $dataProduk = produk::paginate(6);
        return view('admin.produk.home')->with([
            'produk' => $dataProduk,
            'title' => 'data produk'
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk.create')->with([
            'title' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'foto' => 'required',

        ]);

        $produk = new Produk();
        $produk->nama = $request->nama;
        $produk->kategori = $request->kategori;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;

        $gambar = $request->file('foto'); // Use 'file' instead of 'foto'
        $slug = $gambar->getClientOriginalName();
        $new_gambar = time() . '_' . $slug;
        $gambar->move('uploads/produk/', $new_gambar);

        $produk->foto = 'uploads/produk/' . $new_gambar;

        $produk->save();


        return redirect()->route('admin.index')->with('success', 'Data berhasil ditambahkan');
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
        return view('admin.produk.edit')->with([
            'produk' => produk::find($id),
            'title' => 'update',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            // 'foto' => 'image',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->nama = $request->nama;
        $produk->kategori = $request->kategori;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;

        if ($request->hasFile('foto')) {

            if (Storage::exists($produk->foto)) {
                Storage::delete($produk->foto);
            }

            $gambar = $request->file('foto');
            $slug = $gambar->getClientOriginalName();
            $new_gambar = time() . '_' . $slug;
            $gambar->move('uploads/produk/', $new_gambar);

            $produk->foto = 'uploads/produk/' . $new_gambar;
            // dd($produk);
        }

        // dd($produk);
        $produk->save();

        return redirect()->route('admin.index')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = produk::find($id);
        $produk->delete();

        return back()->with('succes', 'Data berhasil di hapus');
    }




    public function userIndex()
    {
        return view('dashboard')->with([
            'produk' => Produk::all(),
            'title' => 'dashboard',
        ]);
    }

    public function produk(Request $request)
    {
        if ($request->has('search')) {
            $dataProduk = produk::where('nama', 'LIKE', '%' . $request->search . '%')->orWhere('stok', 'LIKE', '%' . $request->search . '%')->paginate(6);
        } else {
            $dataProduk = produk::paginate(6);
        }
        return view('produk')->with([
            'produk' => $dataProduk,
            'title' => 'produk',
        ]);
    }

    public function about()
    {
        return view('about')->with([
            'produk' => Produk::all(),
            'title' => 'about',
        ]);
    }

    public function gues(Request $request)
    {
        $dataProduk = Produk::paginate(6);

        if ($request->wantsJson()) {
            return response()->json(['produk' => $dataProduk]);
        }

        return view('dashboard')->with([
            'produk' => $dataProduk,
            'title' => 'gues'
        ]);
    }


    public function adminIndex()
    {
        return view('admin.index')->with([
            'title' => 'dashboard admin'
        ]);
    }
}
