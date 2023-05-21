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
            'fotoprofile' => 'file|image|mimes:jpeg,png,jpg'
        ]);
        if ($validator->fails()) {
            return null;
        }
        if (!is_null($request->fotoprofile)) {
            $file = $request->file('fotoprofile');
            $file_name = time() . "_" . $file->getClientOriginalName();
            $destination = 'fotoprofile';
            $file->move($destination, $file_name);
        }

        $vendor = new Vendor();

        $vendor->user_id = $user_id;
        $vendor->no_hp = $request->no_hp;
        $vendor->alamat = $request->alamat;
        $vendor->nama_vendor = $request->nama_vendor;
        $vendor->desc_vendor = $request->desc_vendor;
        $vendor->range_harga = $request->range_harga;
        $vendor->kontak_vendor = $request->kontak_vendor;
        // $vendor->galeri_vendor = $request->galeri_vendor;
        $vendor->rating_vendor = 0;
        if (!is_null($request->fotoprofile)) $vendor->fotoprofile = $file_name;

        $vendor->save();

        return $vendor;
    }

    static public function show($user_id)
    {
        $vendor = Vendor::where("user_id", $user_id)->first();
        if (is_null($vendor)) {
            return null;
        }
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
            return null;
        }
        $vendor = Vendor::where($user_id, "user_id")->first();

        if (is_null($vendor)) {
            return null;
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

    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        if (!is_null($vendor)) {
            // return response()->json("Data gagal di hapus!", 422);
            $vendor->delete();
        }
        // return new VendorResource(true, 'Data Vendor Berhasil Dihapus!', null);
        return response()->json('Data Vendor Berhasil Dihapus!', 200);
    }
}
