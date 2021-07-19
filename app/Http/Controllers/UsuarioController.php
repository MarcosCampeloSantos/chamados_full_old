<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller{

    public function login()
    {
        if(session()->has('usuario')){
            echo 'Está Logado';
        } else{
            return redirect()-> route('loginUser');
        }

    }

    public function loginUser()
    {
        return view('login');
    }
}






       /*  $login = $request->loginemail;  
        $senha = $request->loginpassword;

        $usuarios = User::where('email', '=', $login)->where('password', '=', $senha)->first();

        if(@$usuarios->id != null){
            @session_start();
            $_SESSION['id_usuario'] = $usuarios->id;
            $_SESSION['nome_usuario'] = $usuarios->name;
            $_SESSION['nivel_usuario'] = $usuarios->nivel;
        

            if($_SESSION['nivel_usuario']=='usuario'){
                return redirect()->route('home');
            }
        }else{
            session()->flash('erro', 'Não existe o usuario.');
            $this->erros();
        }

    }

    public function logout()
    {
        @session_start();
        @session_destroy();
        return redirect()->route('login');
    }

    public function erros(){
        $erro = session('erro');
        $data = [];
        if(!empty($erro)){
            $data = [
                'erro' => $erro
            ];
        }
        return redirect()->route('login', $data);
    }*/

