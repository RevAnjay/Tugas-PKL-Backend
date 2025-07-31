<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Traits\UploadTrait;

class ProductService
{
    use UploadTrait;
    public function StoreProduct(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('images')) {
            $validated['images'] = $this->upload('products', $request->file('images'));
        }

        // $image = $request->file('images');

        // $image->storeAs('products', $image->hashName());

        $product = Product::create([
            'nama_barang' => $validated['nama_barang'],
            'images' => $validated['images'],
            'kategori' => $validated['kategori'],
            'harga' => $validated['harga'],
            'user_id' => $validated['user_id'],
        ]);

        return (object) [
            'product' => $product,
        ];
    }

    public function UpdateProduct(StoreProductRequest $product, Product $data)
    {
        $validatedProduct = $product->validated();

        if ($product->hasFile('images')) {
            if ($data->images) $this->RemoveImage($data);
            $validatedProduct['images'] = $this->upload('products', $product->file('images'));
        }

        return $validatedProduct;
    }

    public function RemoveImage(Product $product)
    {
        if(!$product->images) return false;

        return $this->remove($product->images);
    }
}
