<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;

class ProductService
{
    public function StoreProduct(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $image = $request->file('images');

        $image->storeAs('products', $image->hashName());

        $product = Product::create([
            'nama_barang' => $validated['nama_barang'],
            'images' => $image->hashName(),
            'kategori' => $validated['kategori'],
            'harga' => $validated['harga'],
            'user_id' => $validated['user_id'],
        ]);

        return (object) [
            'product' => $product,
        ];
    }
}
