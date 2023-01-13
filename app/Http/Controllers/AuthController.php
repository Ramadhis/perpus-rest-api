<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\PayUService\Exception;

class AuthController extends Controller
{
    public function register(Request $req) {
        //auto
        // $validator = $req->validate([
        //     'name' => 'required|string|max:100',
        //     'email' => 'required|email|string|max:100|unique:users',
        //     'password' => 'required|string|min:8',
        // ]);

        //manual
        $validator = Validator::make($req->all(),[
            'name' => 'required|string|max:100',
            'email' => 'required|email|string|max:100|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|min:8|same:password',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $insert = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);
        $response['token'] = $insert->createToken('perpustakaan')->plainTextToken;
        return response()->json($response,200);
    }
    
    public function login(Request $req) {
        $validator = Validator::make($req->all(),[
            'email' => 'required|email|string|max:100',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        try {
            if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
                $user = Auth::user();
                $response['token'] = $user->createToken('perpustakaan')->plainTextToken;
                return response()->json($response,200);
            }
            $response['err'] = 'kosong';
            return response()->json($req->password,200);
        } catch (\Exception $err) {
            $data['message'] = 'terjadi kesalahan';
            $data['error'] = $err->getMessage();
            return response()->json($data,404);
        }

    }

    public function get_token(Request $req) {
        return $req->bearerToken();
    }
}