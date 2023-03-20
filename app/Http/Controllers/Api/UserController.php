<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        //get posts
        $users = User::latest()->paginate(10);

        //return collection of users$users as a resource
        return new UserResource(true, 'List Data Users', $users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'=>'required',
            'email'=>'required',
            'password'=>'required',
            'role'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user =User::create([
            'id_user'=>$request->id_user,
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=>$request->role
        ]);

        return new UserResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json('Data not found', 404); 
        }
        return new UserResource(true, 'Data User Ditemukan!', $user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username'=>'required',
            'email'=>'required',
            'password'=>'required',
            'role'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->User::update([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=>$request->role
        ]);

        return new UserResource(true, 'Data User Berhasil Diubah!', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
