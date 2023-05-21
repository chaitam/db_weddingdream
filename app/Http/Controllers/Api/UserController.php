<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Vendor;
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
            'role' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        if ($user->role == "vendor" && !is_null($user->id)) {
            $vendor = VendorController::store($request, $user->id);
            if (!is_null($vendor)) {
                $user = array_merge(
                    $user->toArray(),
                    $vendor->toArray(),
                );
            } else {
                return response()->json("Data vendor tidak terbuat", 404);
            }
        }
        return response()->json($user, 200);


        // return response($response, 200);


        // UserResource(true, 'Data User Berhasil Ditambahkan!', $user);

    }

    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json('Data tidak ditemukan!', 404);
        }
        if ($user->role = "vendor") {
            $vendor = Vendor::where("user_id", $user->id)->first();
            if (!is_null($vendor)) {
                $user = array_merge(
                    $user->toArray(),
                    $vendor->toArray(),
                );
            }
        }
        return response()->json($user, 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        } else {
            if ($user->role = 'vendor') {
                $vendor = Vendor::where("user_id", $user->id)->first();

                if (!is_null($vendor)) {
                    $user = array_merge(
                        $user->toArray(),
                        $vendor->toArray(),
                        // ['token'=> null]
                    );
                }
            }
            if (Hash::check($request->password, $user['password'])) {
                // $token = $user['token']->createToken('Laravel Password Grant Client')->accessToken;
                $user = array_merge(
                    $user,
                    $vendor->toArray(),
                    // ["token" => $token]
                );
                return response($user, 200);
            } else {
                $response = ["message" => "Password salah!"];
                return response($response, 422);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::find($id);


        if (is_null($user)) {
            return response()->json("Data tidak ditemukan!", 200);
        }
        $user->email = $request->email;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        if ($user->role == "vendor") {
            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required',
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
            $vendor = VendorController::show($user->id);

            if (is_null($vendor)) {
            } else {
                VendorController::update($request, $user->id);
                $vendor = VendorController::show($user->id);
                if (!is_null($vendor)) {
                    $user = array_merge(
                        $user->toArray(),
                        $vendor->toArray()
                    );
                }
            }
        }


        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        // return new UserResource(true, 'Data User Berhasil Dihapus!', null);
        return response()->json('Data User berhasil dihapus!', 200);
    }
}
