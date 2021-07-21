<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Chamado;
use Illuminate\Http\Request;

class UsuarioController extends Controller{

    /* Função para verificar e realizar o login */
    public function login(LoginRequest $request)
    {
        $login = $request->loginemail;  
        $senha = $request->loginpassword;
        
        $usuarios = User::where('email', '=', $login)->where('password', '=', $senha)->first();

        if(@$usuarios->email == $login && @$usuarios->password == $senha){
            session()->put('usuario', @$usuarios->email);
            session()->put('name', @$usuarios->name);
            session()->put('id', @$usuarios->id);
            session()->put('nivel', @$usuarios->nivel);

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

    /* Função para Deslogar do Usuario */
    public function sair()
    {
        session()->flush();
        return redirect()->route('loginUser');
    }

    /* Função para Criar Chamados*/
    public function chamadoCriar(Request $request)
    {
        $chamado = new Chamado;
        $chamado->title = $request->titulo;
        $chamado->conteudo = $request->conteudo;
        $chamado->topico = $request->topico;
        $chamado->anexo = $request->anexo;
        $chamado->name = session('name');
        $chamado->user_id = session('id');

        $chamado->save();

        return redirect()->route('homeUser');
    }

    /* Função para Checagem se é um Usuario*/
    private function checarSessao()
    {
        return session()->has('usuario');
    }
    /* Função para Checar se é um Adm*/
    public function checarAdm()
    {
        if(session('nivel') == '1'){
            return true;
        }
    }

    /* Função para Criação de Usuarios*/
    public function criar(Request $request)
    {
        $usuario = new User;
        $usuario ->name = $request->cria_nome;
        $usuario ->departamento = $request->cria_dep;
        $usuario ->email = $request->cria_email;
        $usuario ->password = $request->cria_senha;
        $usuario ->nivel = $request->nivel_user;

        $usuario->save();
        
        return redirect()->route('usuarios');
    }

    /* --------------------REDIRECIONAMENTOS----------------------- */

    public function painelAdm()
    {
        if($this->checarSessao() && $this->checarAdm()){
            return view('admin.paineladm');
        }elseif($this->checarSessao() && !$this->checarAdm()){
            return redirect()->route('homeUser');
        }else{
            return redirect()->route('loginUser');
        }
    }

    /* Função para Redirecionameto da Tela de Login */
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

    /* Função para Redirecionameto da Tela Home de Usuario */
    public function homeUser()  
    {
        if($this->checarSessao() && !$this->checarAdm()){
            $name = session('name');
            $email = session('usuario');
            $data = [
                'name'=> $name,
                'email'=> $email
            ];
            return view('index', $data);
        }elseif($this->checarSessao() && $this->checarAdm()){
            return redirect()->route('homeAdm');
        }else{
            return redirect()->route('loginUser');
        }
        
    }

    /* Função para Redirecionameto da Tela Home de Adm */
    public function homeAdm()
    {
        if($this->checarSessao() && $this->checarAdm()){
            $name = session('name');
            $chamado = Chamado::all();
            $data = [
                'chamado'=> $chamado,
                'name'=> $name,
            ];
            return view('admin.indexadm', $data);
        }elseif($this->checarSessao() && !$this->checarAdm()){
            return redirect()->route('homeUser');
        }else{
            return redirect()->route('loginUser');
        }
        
    }

    /* Função para Redirecionameto da Tela de Criação e Edição de Usuarios*/
    public function usuarios()
    {
        if(!$this->checarSessao() && !$this->checarAdm()){
            $users = User::all();
            return view('admin.usuarios',['users'=>$users]);
        }elseif($this->checarSessao() && !$this->checarAdm()){
            return redirect()->route('homeUser');
        }else{
            return redirect()->route('loginUser');
        }
       
    }

    /* Função para Redirecionameto da Tela de Criação de Chamados */
    public function chamado()
    {
        if($this->checarSessao()){
            return view('chamados');
        }else{
            return redirect()->route('loginUser');
        }
    }

    /* Função para Redirecionameto da Tela de Acompanhamento de Chamados */
    public function acompanharChamados()
    {
        if($this->checarSessao()){
            $chamado = Chamado::all();
            $id = session('id');
            $data = [
                'chamado' => $chamado,
                'id' => $id
            ];
            return view('acompanhar', $data);
        }else{
            return redirect()->route('loginUser');
        }
        
    }
}
