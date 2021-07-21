<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller{

    public function login(LoginRequest $request)
    {
        $login = $request->loginemail;  
        $senha = $request->loginpassword;
        
        $usuarios = User::where('email', '=', $login)->where('password', '=', $senha)->first();

        if(@$usuarios->email == $login && @$usuarios->password == $senha){
            session()->put('usuario', @$usuarios->email);

            if(@$usuarios->nivel =='1'){
                return redirect()->route('homeAdm');
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
        return session()->has('usuario');
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
        if($this->checarSessao()){
            return view('index');
        }else{
            return redirect()->route('loginUser');
        }
        
    }

    public function homeAdm()
    {
        if($this->checarSessao()){
            return view('admin.indexadm');
        }else{
            return redirect()->route('loginUser');
        }
        
    }

    public function usuarios()
    {
        if($this->checarSessao()){
            $users = User::all();
            return view('admin.usuarios',['users'=>$users]);
        }else{
            return redirect()->route('loginUser');
        }
       
    }

    public function criarChamado()
    {
        if($this->checarSessao()){
            return view('criar_chamados');
        }else{
            return redirect()->route('loginUser');
        }
        return view('criar_chamados');
    }

    public function acompanharChamados()
    {
        if($this->checarSessao()){
            return view('acompanhar');
        }else{
            return redirect()->route('loginUser');
        }
        
    }
}

