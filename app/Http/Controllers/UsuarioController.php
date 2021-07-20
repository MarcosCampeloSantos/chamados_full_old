<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller{

    public function login(LoginRequest $request)
    {
        $login = $request->loginemail;  
        $senha = $request->loginpassword;
        
        $usuarios = User::where('email', '=', $login)->where('password', '=', $senha)->first();

        if(@$usuarios->email == $login && @$usuarios->password == $senha){
            @session_start();
            $_SESSION['id_usuario'] = $usuarios->id;
            $_SESSION['nome_usuario'] = $usuarios->name;
            $_SESSION['nivel_usuario'] = $usuarios->nivel;
        

            if($_SESSION['nivel_usuario']=='1'){
                return redirect()->route('painelAdm');
            }else{
                return redirect()->route('homeUser');
            }
        }elseif(User::where('email', '!=', $login)->first()){
            session()->flash('erro', 'Usuario Não Existe');
            return redirect()->route('loginUser');
        }elseif($senha != @$usuarios->password){
            session()->flash('erro', 'Senha Incorreta');
            return redirect()->route('loginUser');
        }

        

    }

    private function checarSessao()
    {
        return session()->has('id_usuario');
    }

    public function criar(Request $request)
    {
        $usuario = new User;
        $usuario ->name = $request->cria_nome;
        $usuario ->email = $request->cria_email;
        $usuario ->password = $request->cria_senha;
        $usuario ->nivel = $request->nivel_user;

        $usuario->save();
        
        return redirect()->route('usuarios');
    
    }

    public function loginUser()
    {

        $erro = session('erro');
        $data = [];
        if(!empty($erro)){
            $data = [
                'erro' => $erro
            ];
        }

        return view('login', $data);
    }


    public function homeUser()  
    {
        return view('index');
    }

    public function homeAdm()
    {
        return view('admin.indexadm');
    }

    public function usuarios()
    {
        $users = User::all();
        return view('admin.usuarios',['users'=>$users]);
    }

    public function criarChamado()
    {
        return view('criar_chamados');
    }

    public function acompanharChamados()
    {
        return view('acompanhar');
    }
}

