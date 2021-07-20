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

        

        if($this->checarSessao()){
            return redirect()->route('homeUser');
        }

        $login = $request->loginemail;  
        $senha = $request->loginpassword;
        
        $usuarios = User::where('email', '=', $login)->where('password', '=', $senha)->first();

        if(@$usuarios->id != null){
            @session_start();
            $_SESSION['id_usuario'] = $usuarios->id;
            $_SESSION['nome_usuario'] = $usuarios->name;
            $_SESSION['nivel_usuario'] = $usuarios->nivel;
        

            if($_SESSION['nivel_usuario']=='1'){
                return redirect()->route('painelAdm');
            }else{
                return redirect()->route('HomeUser');
            }
        }elseif(User::where('email', '!=', $login)->first()){
            session()->flash('erro', 'Usuario Não Existe');
            return redirect()->route('loginUser');
        }elseif(!Hash::check($senha, @$usuarios->password)){
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
        $usuario ->password = Hash::make($request->cria_senha);
        $usuario ->nivel = $request->nivel_user;

        $usuario->save();
        
        return redirect()->route('loginUser');
    }

    public function loginUser()
    {
        if($this->checarSessao()){
            return redirect()->route('homeUser');
        }

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

    public function usuarios()
    {
        return view('admin.usuarios');
    }
}






       /*$login = $request->loginemail;  
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

