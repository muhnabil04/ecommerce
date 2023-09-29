<?php

namespace App\Exports;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;

class RiwayatExport implements FromArray
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $result = [
            ['No', 'Nama', 'Harga', 'jumlah', 'Total harga', 'Tanggal']
        ];

        $nomor = 1;
        foreach ($this->data as $row) {
            $result[] = [
                $nomor++,
                $row['produk_nama'],
                $row['produk_harga'],
                $row['jumlah'],
                $row['jumlah_harga'],
                $row['created_at']
            ];
        }

        return $result;
    }
}
