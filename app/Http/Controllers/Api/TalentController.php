<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TalentResource;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TalentController extends Controller
{
    public function index()
    {
        //get posts
        $talents = Talent::latest()->paginate(10);

        //return collection of talents$talents as a resource
        return new TalentResource(true, 'List Data Talents', $talents);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'=>'required',
            'profesi'=>'required',
            'range_harga'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $talent =Talent::create([
            'id_talent'=>$request->id_talent,
            'customer_id'=>$request->customer_id,
            'profesi'=>$request->profesi,
            'range_harga'=>$request->range_harga
        ]);

        return new TalentResource(true, 'Data Talent Berhasil Ditambahkan!', $talent);
    }

    public function show($id)
    {
        $talent = Talent::find($id);
        if (is_null($talent)) {
            return response()->json('Data not found', 404); 
        }
        return new TalentResource(true, 'Data Talent Ditemukan!', $talent);
    }

    public function update(Request $request, Talent $talent)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'=>'required',
            'profesi'=>'required',
            'range_harga'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $talent->Talent::update([
            'customer_id'=>$request->customer_id,
            'profesi'=>$request->profesi,
            'range_harga'=>$request->range_harga
        ]);

        return new TalentResource(true, 'Data Talent Berhasil Diubah!', $talent);
    }

    public function destroy(Talent $talent)
    {
        $talent->delete();
        return new TalentResource(true, 'Data Talent Berhasil Dihapus!', null);
    }
}
