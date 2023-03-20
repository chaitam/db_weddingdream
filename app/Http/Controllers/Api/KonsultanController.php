<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KonsultanResource;
use App\Models\Konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonsultanController extends Controller
{
    public function index()
    {
        //get posts
        $konsultans = Konsultan::latest()->paginate(10);

        //return collection of konsultans as a resource
        return new KonsultanResource(true, 'List Data Konsultans', $konsultans);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
            'desc_konsultan'=>'required',
            'fotoprofile'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $konsultan =Konsultan::create([
            'id_customer'=>$request->id_customer,
            'user_id'=>$request->user_id,
            'no_hp'=>$request->no_hp,
            'alamat'=>$request->alamat,
            'desc_konsultan'=>$request->desc_konsultan,
            'fotoprofile'=>$request->fotoprofile
        ]);

        return new KonsultanResource(true, 'Data Konsultan Berhasil Ditambahkan!', $konsultan);
    }

    public function show($id)
    {
        $konsultan = Konsultan::find($id);
        if (is_null($konsultan)) {
            return response()->json('Data not found', 404); 
        }
        return new KonsultanResource(true, 'Data Konsultan Ditemukan!', $konsultan);
    }

    public function update(Request $request, Konsultan $konsultan)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
            'desc_konsultan'=>'required',
            'fotoprofile'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $konsultan->Konsultan::update([
            'user_id'=>$request->user_id,
            'no_hp'=>$request->no_hp,
            'alamat'=>$request->alamat,
            'desc_konsultan'=>$request->desc_konsultan,
            'fotoprofile'=>$request->fotoprofile
        ]);

        return new KonsultanResource(true, 'Data Konsultan Berhasil Diubah!', $konsultan);
    }

    public function destroy(Konsultan $konsultan)
    {
        $konsultan->delete();
        return new KonsultanResource(true, 'Data Konsultan Berhasil Dihapus!', null);
    }
}
