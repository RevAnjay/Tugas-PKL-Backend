<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'nama_barang' => $this->nama_barang,
            'kategori' => $this->kategori,
            'harga' => $this->harga,
            'id' => $this->id,
            'pemilik_barang' => [
                'id' => $this->owner->id,
                'nama' => $this->owner->username
            ]
        ];
    }
}
