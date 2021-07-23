<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Chamado;
use App\Models\Topico;
use App\Models\Interacoe;
use App\Models\Relacionamento;
use App\Models\Atendimento;
use App\Models\Departamento;
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
            session()->put('departamento', @$usuarios->departamento);

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

    public function criarTop(Request $request)
    {
        $topicos = new Topico;
        $topicos->topicos = $request->cria_top;

        $topicos->save();
        return redirect()->route('paineladm');
        
    }

    /* Função para Criando Relacionamentos */

    public function criarRel(Request $request)
    {
        $relacionamentos = new Relacionamento;
        $relacionamentos->departamentos_id = $request->rel_dep;
        $relacionamentos->topicos_id = $request->rel_top;

        $relacionamentos->save();

        return redirect()->route('paineladm');
    }

    /* Função para Criar os Departamentos */
    public function criarDep(Request $request)
    {
        $departamento = new Departamento;
        $departamento->departamento = $request->cria_dep;

        $departamento->save();
        return redirect()->route('paineladm');
    }

    /* Função para Criar Chamados*/
    public function chamadoCriar(Request $request)
    {
        $chamado = new Chamado;
        $chat = new Interacoe;
        $chamado->title = $request->titulo;
        $chamado->topico = $request->topico;
        $chamado->anexo = $request->anexo;
        $chamado->name = session('name');
        $chamado->user_id = session('id');

        $chamado->save();

        $chat->user_id = session('id');
        $chat->chat = $request->conteudo;
        $chat->chamado_id = $chamado->id;

        $chat->save();
        

        return redirect()->route('homeUser');
    }

    /* Função para Envio de mensagens nos Chamados */
    public function envChat(Request $request)
    {
        $chat = new Interacoe;
        $chat->user_id = session('id');
        $chat->chamado_id = $request->id_chamado;
        $chat->chat = $request->chat;

        $chat->save();
        if($this->checarAdm()){
            return redirect()->route('homeAdm');
        }elseif(!$this->checarAdm()){
            return redirect()->route('acompanhar');
        }
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
        $usuario ->departamento = $request->dep_user;
        $usuario ->email = $request->cria_email;
        $usuario ->password = $request->cria_senha;
        $usuario ->nivel = $request->nivel_user;

        $usuario->save();
        
        return redirect()->route('usuarios');
    }

    /* --------------------REDIRECIONAMENTOS----------------------- */

    /* Função para Redirecionameto do Painel Administrativo */
    public function painelAdm()
    {
        if($this->checarSessao() && $this->checarAdm()){
            $relacionamentos = Relacionamento::all();
            $departamento = Departamento::all();
            $topicos = Topico::all();
            $data=[
                'relacionamentos' => $relacionamentos,
                'topicos' => $topicos,
                'departamento'=> $departamento
            ];
            return view('admin.paineladm', $data);
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
            $departamento = session('departamento');
            $topicos = Topico::all();
            $usuarios = User::all();
            $chamado = Chamado::all();
            $chat = Interacoe::all();
            $status= Atendimento::all();
            $relacionamentos = Relacionamento::all();
            
            $data = [
                'relacionamentos' => $relacionamentos,
                'departamento' => $departamento,
                'status' => $status,
                'topicos' => $topicos,
                'name' => $name,
                'interacoes' => $chat,
                'chamado'=> $chamado,
                'usuarios'=> $usuarios
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
        if($this->checarSessao() && $this->checarAdm()){
            $departamento = Departamento::all();
            $users = User::all();
            $data = [
                'users' => $users,
                'departamento' => $departamento
            ];
            return view('admin.usuarios', $data);
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
            $topicos = Topico::all();
            $data = [
                'topicos' => $topicos
            ];
            return view('chamados', $data);
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
            $usuarios = User::all();
            $chat = Interacoe::all();
            $data = [
                'interacoes' => $chat,
                'chamado' => $chamado,
                'id' => $id,
                'usuarios'=> $usuarios
            ];
            return view('acompanhar', $data);
        }else{
            return redirect()->route('loginUser');
        }
        
    }
}

