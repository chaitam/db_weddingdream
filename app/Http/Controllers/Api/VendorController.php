<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index()
    {
        //get posts
        $vendors = Vendor::latest()->paginate(10);

        //return collection of vendors$vendors as a resource
        // return new VendorResource(true, 'List Data Vendors', $vendors);
        return response()->json($vendors, 200);
    }

    static public function store(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => 'required',
            'alamat' => 'required',
            'nama_vendor' => 'required',
            'desc_vendor' => 'required',
            'range_harga' => 'required',
            'kontak_vendor' => 'required',
            // 'galeri_vendor' => 'required',
            // 'fotoprofile' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vendor = Vendor::create([
            'user_id' => $user_id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'nama_vendor' => $request->nama_vendor,
            'desc_vendor' => $request->desc_vendor,
            'range_harga' => $request->range_harga,
            'kontak_vendor' => $request->kontak_vendor,
            'galeri_vendor' => $request->galeri_vendor,
            'rating_vendor' => 0,
            'fotoprofile' => $request->fotoprofile
        ]);

        // return new VendorResource(true, 'Data Vendor Berhasil Ditambahkan!', $vendor);
        return $vendor;
    }

    static public function show($user_id)
    {
        $vendor = Vendor::where("user_id", $user_id)->first();
        // if (is_null($vendor)) {
        //     return response()->json('Data not found', 404);
        // }
        if (is_null($vendor)) {
            return null;
        }
        // return new VendorResource(true, 'Data Vendor Ditemukan!', $vendor);
        // return response()->json($vendor, 200);
        return $vendor;
    }

    static public function update(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'nama_vendor' => 'required',
            'desc_vendor' => 'required',
            'range_harga' => 'required',
            'kontak_vendor' => 'required',
            // 'galeri_vendor' => 'required',
            // 'fotoprofile' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $vendor = Vendor::where($user_id, "user_id")->first();

        if (is_null($vendor)) {
            return response()->json("Data tidak ditemukan!");
        }
        $vendor->no_hp = $request->no_hp;
        $vendor->alamat = $request->alamat;
        $vendor->nama_vendor = $request->nama_vendor;
        $vendor->desc_vendor = $request->desc_vendor;
        $vendor->range_harga = $request->range_harga;
        $vendor->kontak_vendor = $request->kontak_vendor;
        $vendor->galeri_vendor = $request->galeri_vendor;
        $vendor->fotoprofile = $request->fotoprofile;
        $vendor->save();
        // return new VendorResource(true, 'Data Vendor Berhasil Diubah!', $vendor);
        // return response()->json($vendor, 200);
        return $vendor;
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        // return new VendorResource(true, 'Data Vendor Berhasil Dihapus!', null);
        return response()->json('Data Vendor Berhasil Dihapus!', 200);
    }
}
