<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Kategori;
use App\Services\ProductService;
use DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function add(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->productService->StoreProduct($request);

            DB::commit();
            return ResponseHelper::success($product, "berhasil menambahkan barang dengan nama: {$request->nama_barang}");
        } catch (\Throwable $thrw) {
            DB::rollBack();
            return ResponseHelper::error(message: $thrw->getMessage());
        }
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

    public function update(StoreProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Product::find($id);
            $product = $this->productService->UpdateProduct($request, $data);
            $data->update($product);

            DB::commit();
            return ResponseHelper::success($data, 'barang berhasil diubah');
        } catch (\Throwable $thrw) {
            DB::rollBack();
            return ResponseHelper::error(message: $thrw->getMessage());
        }
        // if (!Auth::check()) return response()->json([
        //     'status' => 'unauthorized',
        //     'message' => 'maaf kamu belum login',
        // ]);

        // $data = Product::find($id);

        // if (!$data) return response()->json([
        //     'status' => 'failed',
        //     'message' => 'maaf barang dengan id tersebut tidak dapat ditemukan',
        // ]);

        // $data->update([
        //     'nama_barang' => $request->nama_barang,
        //     'kategori' => $request->kategori,
        //     'harga' => $request->harga,
        //     'user_id' => $request->user_id,
        // ]);

        // return ResponseHelper::success(message: 'barang berhasil diubah');
    }

    public function remove($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $this->productService->RemoveImage($product);
            $product->delete();

            DB::commit();
            return ResponseHelper::success(message: "berhasil menghapus barang");
        } catch (\Throwable $thrw) {
            DB::rollBack();
            return ResponseHelper::error(message: $thrw->getMessage());
        }
        // if (!Auth::check())return response()->json([
        //     'status' => 'unauthorized',
        //     'message' => 'maaf kamu belum login',
        // ]);

        // $data = Product::find($id);

        // if (!$data) return response()->json([
        //     'status' => 'failed',
        //     'message' => 'maaf barang dengan id tersebut tidak dapat ditemukan',
        // ]);

        // $data->delete();

        // return ResponseHelper::success(message: 'barang berhasil dihapus');
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
