<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Administrador;
use App\Models\Almacenero;
use App\Models\Chofer;
use Lcobucci\JWT\Parser;


class UserController extends Controller
{
    public function Register(Request $request){

        $validation = Validator::make($request->all(),[
            'nombre' => 'required|max:32',
            'apellido' => 'required|max:32',
            'username' => 'required|unique:usuario',
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

    public function Login(Request $request) {
        $user = Usuario::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'message' => 'No se ha encontrado el usuario'
            ], 404);
        }

        if (password_verify($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->accessToken;
            $user->token = $token;
            auth()->login($user);
            return response()->json([
                'message' => 'Logueado',
                'user' => $user
            ]);
        }
        return response()->json([
            'message' => 'La contraseña ingresada es incorrecta'
        ], 401);
    }

    
    public function GetUsuarioRoles(Request $request){

        Usuario::findOrFail($request->id);

        $roles['isAdministrador'] = Administrador::where('id', $request -> id)->exists();
        $roles['isAlmacenero'] = Almacenero::where('id', $request -> id)->exists();
        $roles['isChofer'] = Chofer::where('id', $request -> id)->exists();

        return $roles;
    }
    
}
