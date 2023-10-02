<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;
use App\Models\Administrador;
use App\Models\Almacenero;
use App\Models\Chofer;




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

    public function ValidarUsuario(Request $request){
        
        $usuario = Usuario::where('username', $request -> post("username"))->first();
        
        if(!$usuario -> exists()){
            header("HTTP/1.0 404 Not Found");
            echo "Error 404: Usuario no encontrado";
            exit();
        }
        if(!password_verify($request->post("password"), $usuario->password)){
            header("HTTP/1.0 401 Unauthorized");
            echo "Error 401: Acceso no autorizado";
            exit();
        }

        return $usuario;
        
    }

    public function GetUsuarioRoles(Request $request){

        $roles['isAdministrador'] = Administrador::where('id', $request -> id)->exists();
        $roles['isAlmacenero'] = Almacenero::where('id', $request -> id)->exists();
        $roles['isChofer'] = Chofer::where('id', $request -> id)->exists();

        return $roles;
    }
    
}
