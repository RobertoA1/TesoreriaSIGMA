<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function iniciarSesion(Request $request){
        $data = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ],  [
            'email.required'=>'Ingrese correo electrónico',
            'password.required'=>'Ingrese contraseña',
        ]);

        if (Auth::attempt($data)){
            return redirect(route('home'));
        }

        $name = $request->get("email");
        $query = User::where('email', '=', $name)->get();

        if ($query->count() == 0){
            return back()->withErrors(['email' => "Correo electrónico no válido."])->withInput(request(['email']));
        }

        $hashp = $query[0]->password;
        $password = $request->get("password");

        if (!password_verify($password, $hashp)){
            return back()->withErrors(['password' => "Contraseña no válida."])->withInput(request(['email']));
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect(route('inicio'));
    }
}
