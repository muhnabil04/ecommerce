<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo('App\Models\produk', 'produk_id', 'id');
    }

    public function pesanan()
    {
        return $this->hasMany('App\Pesanan', 'pesanan_id', 'id');
    }
}
