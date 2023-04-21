<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $user = User::create([
            // 'id' => $request->id_user,
            // 'id_user' => $request->id_user,
            'email' => $request->email,
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => $request->role
            // 'bidang' => $request->bidang,
            // 'image' => $request->image,
        ]);

        return response()->json([

            "data" => $user,
        ], 200,);

        // return response($response, 200);


        // UserResource(true, 'Data User Berhasil Ditambahkan!', $user);

    }

    public function show($email)
    {
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([
            "data" => $user
        ], 200,);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->User::update([
            'email' => $request->email,
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => $request->role
        ]);

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
