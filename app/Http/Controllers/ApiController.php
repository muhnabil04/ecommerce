<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;

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
