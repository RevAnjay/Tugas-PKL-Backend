<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'maaf kamu belum login',
            ]);
        }

        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|integer',
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
            'harga' => $request->harga,
        ]);

        return response()->json([
            'status' => 'sukses',
            'message' => "berhasil menambahkan barang dengan nama: {$request->nama_barang}",
        ]);

    }

    public function get()
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'maaf kamu belum login',
            ]);
        }

        $data = Product::all();

        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'maaf barang tidak dapat ditemukan',
            ]);
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'maaf kamu belum login',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'maaf data yang anda masukan tidak valid',
            ]);
        }

        $data = Product::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'maaf barang dengan id tersebut tidak dapat ditemukan',
            ]);
        }

        $data->update([
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'status' => 'sukses',
            'message' => 'barang berhasil diubah'
        ]);
    }

    public function remove($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'maaf kamu belum login',
            ]);
        }

        $data = Product::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'maaf barang dengan id tersebut tidak dapat ditemukan',
            ]);
        }

        $data->delete();

        return response()->json([
            'status' => 'sukses',
            'message' => 'barang berhasil dihapus'
        ]);
    }
}
