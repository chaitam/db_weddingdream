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
        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'password'=>'required',
            'role'=>'required'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user =User::create([
            // 'id_user'=>$request->id_user,
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>$request->password,
            'phone'=>$request->phone,
            'role'=>$request->role
        ]);

        return response()->json($user, 200);
    }

    public function show($email)
    {
        // $user = User::find($id)
        $user = User::where('email',$email) -> first();
        if (is_null($user)) {
            return response()->json('Data not found', 404);
        }
        // return new UserResource(true, 'Data User Ditemukan!', $user);
        return response()->json($user, 200);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'username'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'password'=>'required',
            'role'=>'required'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->User::update([
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>$request->password,
            'role'=>$request->role
        ]);

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
