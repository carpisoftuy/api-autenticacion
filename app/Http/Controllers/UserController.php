<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;




class UserController extends Controller
{
    public function Register(Request $request){

        $validation = Validator::make($request->all(),[
            'nombre' => 'required|max:32',
            'apellido' => 'required|max:32',
            'username' => 'required|email|unique:usuarios',
            'password' => 'required|confirmed'
        ]);

        if($validation->fails())
            return $validation->errors();

        return $this -> createUser($request);
        
    }

    private function createUser($request){
        $usuario = new Usuario();
        $usuario -> nombre = $request -> post("nombre");
        $usuario -> apellido = $request -> post("apellido");
        $usuario -> username = $request -> post("username");
        $usuario -> password = Hash::make($request -> post("password"));   
        $usuario -> save();
        return $usuario;
    }

    public function ValidateToken(Request $request){
        return auth('api')->user();
    }

    public function Logout(Request $request){
        $request->user()->token()->revoke();
        return ['message' => 'Token Revoked'];
        
        
    }

    
}
