<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
// use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        return response([
            'success' => 1,
            'data' => $products,
            'message' => "Berhasil mengambil data!"
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'data' => null,
                'message' => $validator->errors()
            ], 401);
        }

        $product = Product::create($input);

        if ($product) {
            return response([
                'success' => 1,
                'data' => null,
                'message' => "Data berhasil ditambah!"
            ]);
        } else {
            return response([
                'success' => 0,
                'data' => null,
                'message' => "Data gagal ditambah!"
            ], 500);
        }
    }

    public function get($id)
    {

        $product = Product::find($id);

        if (!$product) {
            return response([
                'success' => 0,
                'data' => null,
                'message' => "Tidak ada data!"
            ], 404);
        } else {
            return response([
                'success' => 1,
                'data' => $product,
                'message' => "Data berhasil diambil!"
            ]);
        }
    }

    public function update(Request $request, $id)
    {

        $input = $request->input();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'data' => null,
                'message' => $validator->errors()
            ], 401);
        }

        $product = Product::find($id);

        if (!$product) {
            return response([
                'success' => 0,
                'data' => null,
                'message' => "Tidak ada data!"
            ], 404);
        }

        $product->update($input);

        return response([
            'success' => 1,
            'data' => null,
            'message' => "Data berhasil diupdate!"
        ]);
    }

    public function delete(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response([
                'success' => 0,
                'data' => null,
                'message' => "Tidak ada data!"
            ], 404);
        }

        $product->delete();

        return response([
            'success' => 1,
            'data' => null,
            'message' => "Data berhasil dihapus!"
        ]);
    }
}
