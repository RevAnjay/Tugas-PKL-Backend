<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_barang',
        'images',
        'kategori',
        'harga',
        'user_id',
    ];

    public function Owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori');
    }
}
