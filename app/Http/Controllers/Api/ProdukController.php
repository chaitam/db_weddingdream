<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdukResource;
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
        return new ProdukResource(true, 'List Data Talents', $produks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id'=>'required',
            'harga'=>'required',
            'nama_produk'=>'required',
            'desc_produk'=>'required',
            'foto_produk'=>'required',
            'rating'=>'required',
            'ulasan'=>'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk =Produk::create([
            'id_produk'=>$request->id_produk,
            'vendor_id'=>$request->vendor_id,
            'harga'=>$request->harga,
            'nama_produk'=>$request->nama_produk,
            'desc_produk'=>$request->desc_produk,
            'foto_produk'=>$request->foto_produk,
            'rating'=>$request->rating,
            'ulasan'=>$request->ulasan,
        ]);

        return new ProdukResource(true, 'Data Produk Berhasil Ditambahkan!', $produk);
    }

    public function show($id)
    {
        $produk = Produk::find($id);
        if (is_null($produk)) {
            return response()->json('Data not found', 404); 
        }
        return new ProdukResource(true, 'Data Produk Ditemukan!', $produk);
    }

    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id'=>'required',
            'harga'=>'required',
            'nama_produk'=>'required',
            'desc_produk'=>'required',
            'foto_produk'=>'required',
            'rating'=>'required',
            'ulasan'=>'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk->Produk::update([
            'vendor_id'=>$request->vendor_id,
            'harga'=>$request->harga,
            'nama_produk'=>$request->nama_produk,
            'desc_produk'=>$request->desc_produk,
            'foto_produk'=>$request->foto_produk,
            'rating'=>$request->rating,
            'ulasan'=>$request->ulasan,
        ]);

        return new ProdukResource(true, 'Data Produk Berhasil Diubah!', $produk);
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return new ProdukResource(true, 'Data Produk Berhasil Dihapus!', null);
    }
}