<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        //get posts
        $produks = Produk::latest()->paginate(10);

        //return collection of produks$produks$produks as a resource
        // return new ProdukResource(true, 'List Data Talents', $produks);
        return response()->json($produks, 200);
    }
    public function myIndex($vendor_id)
    {
        //get posts
        $produks = Produk::where("vendor_id", $vendor_id)->latest()->paginate(10);
        if (is_null($produks)) {
            return response()->json("Data kosong!", 402);
        }


        //return collection of produks$produks$produks as a resource
        // return new ProdukResource(true, 'List Data Talents', $produks);
        return response()->json($produks, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'harga' => 'required|integer',
            'nama_produk' => 'required',
            'desc_produk' => 'required',
            'foto_produk' => 'required|file|image|mimes:jpeg,png,jpg',
            // 'foto_produk' => 'required',
            // 'rating'=>'required',
            // 'ulasan'=>'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $file = $request->file('foto_produk');
        $file_name = time() . "_" . $file->getClientOriginalName();
        $destination = 'fotoproduk';
        $file->move($destination, $file_name);

        $produk = new Produk();
        $produk->vendor_id = $request->vendor_id;
        $produk->harga = $request->harga;
        $produk->nama_produk = $request->nama_produk;
        $produk->desc_produk = $request->desc_produk;
        $produk->foto_produk = $destination . "/" . $file_name;
        $produk->save();
        // $produk = Produk::create([
        //     // 'id_produk' => $request->id_produk,
        //     'vendor_id' => $request->vendor_id,
        //     'harga' => $request->harga,
        //     'nama_produk' => $request->nama_produk,
        //     'desc_produk' => $request->desc_produk,
        //     'foto_produk' => $file_name,
        //     // 'rating'=>$request->rating,
        //     // 'ulasan'=>$request->ulasan,
        // ]);

        // return new ProdukResource(true, 'Data Produk Berhasil Ditambahkan!', $produk);
        return response()->json($produk, 200);
    }

    public function show($id)
    {
        $produk = Produk::find($id);
        if (is_null($produk)) {
            return response()->json('Data not found', 404);
        }
        // return new ProdukResource(true, 'Data Produk Ditemukan!', $produk);
        return response()->json($produk, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'harga' => 'required',
            'nama_produk' => 'required',
            'desc_produk' => 'required',
            'foto_produk' => 'required|file|image|mimes:jpeg,png,jpg',
            // 'rating'=>'required',
            // 'ulasan'=>'required',

        ]);


        $file = $request->file('foto_produk');


        $file_name = time() . "_" . $file->getClientOriginalName();
        $destination = 'fotoproduk';
        $file->move($destination, $file_name);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $produk = Produk::find($id);
        if (is_null($produk)) {
            return response()->json('Data tidak ditemukan', 404);
        }
        $produk->vendor_id = $request->vendor_id;
        $produk->harga = $request->harga;
        $produk->nama_produk = $request->nama_produk;
        $produk->desc_produk = $request->desc_produk;
        $produk->foto_produk = $file_name;
        $produk->save();
        return response()->json($produk, 200);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!is_null($produk)) {
            $produk->delete();
        }
        // return new ProdukResource(true, 'Data Produk Berhasil Dihapus!', null);
        return response()->json("Berhasil menghapus data", 200);
    }
}
