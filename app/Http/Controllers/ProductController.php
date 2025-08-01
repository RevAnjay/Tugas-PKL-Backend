<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function add(Request $request)
    {
        if (!Auth::check()) return response()->json([
            'status' => 'unauthorized',
            'message' => 'maaf kamu belum login',
        ]);

        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'harga' => 'required|integer',
            'user_id' => 'required',
        ]);

        // $validator = Validator::make($request->all(), [
        //     'nama_barang' => 'required',
        //     'harga' => 'required|integer',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'maaf data yang anda masukan tidak valid',
        //     ]);
        // }

        Product::create([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => 'sukses',
            'message' => "berhasil menambahkan barang dengan nama: {$request->nama_barang}",
        ]);

    }

    public function get()
    {
        if (!Auth::check()) return response()->json([
            'status' => 'unauthorized',
            'message' => 'maaf kamu belum login',
        ]);

        $data = Product::all();

        if (!$data) return response()->json([
            'status' => 'failed',
            'message' => 'maaf barang tidak dapat ditemukan',
        ]);

        return ProductResource::collection($data);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) return response()->json([
            'status' => 'unauthorized',
            'message' => 'maaf kamu belum login',
        ]);

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'kategori' => 'required',
            'harga' => 'required|integer',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json([
                'status' => 'failed',
                'message' => 'maaf data yang anda masukan tidak valid',
            ]);

        $data = Product::find($id);

        if (!$data) return response()->json([
            'status' => 'failed',
            'message' => 'maaf barang dengan id tersebut tidak dapat ditemukan',
        ]);

        $data->update([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => 'sukses',
            'message' => 'barang berhasil diubah'
        ]);
    }

    public function remove($id)
    {
        if (!Auth::check())return response()->json([
            'status' => 'unauthorized',
            'message' => 'maaf kamu belum login',
        ]);

        $data = Product::find($id);

        if (!$data) return response()->json([
            'status' => 'failed',
            'message' => 'maaf barang dengan id tersebut tidak dapat ditemukan',
        ]);

        $data->delete();

        return response()->json([
            'status' => 'sukses',
            'message' => 'barang berhasil dihapus'
        ]);
    }

    public function kategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
        ]);

        Kategori::create(['nama_kategori'=>$request->nama_kategori]);

        return response()->json([
            'message' => 'kategori berhasil dibuat',
        ]);
    }
}
