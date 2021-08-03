<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use App\Models\Chamado;
use App\Models\Tempo;
use App\Models\Topico;
use App\Models\Interacoe;
use App\Models\Relacionamento;
use App\Models\Departamento;
use DateTime;
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

            if(@$usuarios->nivel == '1'){
                return redirect()->route('homeAdm');
            }elseif(@$usuarios->nivel == '2'){
                return redirect()->route('homeUser');
            }elseif(@$usuarios->nivel == '3'){
                return redirect()->route('homeSup');
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

    /* Função para Criação de Topicos de Atendimento */
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
        if(!Relacionamento::where('departamentos_id', '=', $request->rel_dep)->where('topicos_id', '=', $request->rel_top)->first()){
            $relacionamentos->departamentos_id = $request->rel_dep;
            $relacionamentos->topicos_id = $request->rel_top;
            $relacionamentos->save();

            return redirect()->route('paineladm');
        }else{
            session()->flash('errorelacionameto', 'Relacionamento já Existe');
            return redirect()->route('paineladm');
        }

        
    }

    public function editarRel(Request $request)
    {
        $idrel = $request->id_relacionamento;
        $rel = Relacionamento::where('id', '=', $idrel )->first();
        if ($rel->id == $idrel && !Relacionamento::where('departamentos_id', '=', $request->rel_dep)->where('topicos_id', '=', $request->rel_top)->first()) {
            $rel->departamentos_id = $request->rel_dep;
            $rel->topicos_id = $request->rel_top;

            $rel->save();
            return redirect()->route('paineladm');
        }else{
            session()->flash('errorelacionameto', 'Relacionamento já Existe');
            return redirect()->route('paineladm');
        }

        
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

        $chamado->departamento = session('departamento');
        $chamado->status_id = '1';
        $chamado->IP = $_SERVER['REMOTE_ADDR'];
        $chamado->title = $request->titulo;
        $chamado->topico = $request->topico;
        $chamado->name = session('name');
        $chamado->user_id = session('id');

        $chamado->save();

        $chat->anexo = $request->anexo;
        $chat->user_id = session('id');
        $chat->chat = $request->conteudo;
        $chat->chamado_id = $chamado->id;

        $chat->save();
        

        return redirect()->route('chamado');
    }

    /* Função para Envio de mensagens nos Chamados */
    public function envChat(Request $request)
    {
        $chamado = Chamado::where('id', '=', $request->id_chamado)->first();
        $chat = new Interacoe;
        $tempo = new Tempo;
        $databanco = new DateTime(date('Y/m/d H:i:s'));
        $tempopause = Tempo::where('chamado_id', '=', $request->id_chamado)->where('pausado', '=', '0')->first();
        $temposoma = 0;
        if (!empty($request->chat)) {
            if($this->checarAdm()){
                $chamado->status_id = $request->status_chamado;
            }elseif(!$this->checarAdm() && $chamado->status_id == '2'){
                $chamado->status_id = '1';
            }
            $chat->user_id = session('id');
            $chat->chamado_id = $request->id_chamado;
            $chat->chat = $request->chat;

            $chat->save();
            $chamado->save();

            if($chamado->status_id == '4'){
                $tempopause->termino = $databanco->format('Y/m/d H:i:s');
                $tempopause->pausado = '1';
                $tempopause->save();
    
                $diferenca = strtotime($tempopause->termino) - strtotime($tempopause->inicio);
    
                $tempopause->tempototal = gmdate("H:i:s", $diferenca);
                $tempopause->save();
                session()->put('pause', $tempopause->pausado);
            }elseif($chamado->status_id == '2'){
                $tempopause->termino = $databanco->format('Y/m/d H:i:s');
                $tempopause->save();
    
                $diferenca = strtotime($tempopause->termino) - strtotime($tempopause->inicio);
    
                $tempopause->tempototal = gmdate("H:i:s", $diferenca);
                $tempopause->save();
    
                $tempototal = Tempo::all();
    
                foreach ($tempototal as $key) {
                    if($key->chamado_id == $chamado->id){
                        $temposoma = $temposoma + (strtotime($key->termino) - strtotime($key->inicio));
                    }
                }
                $tempopause->pausado = '2';
                $tempopause->finalizado = gmdate("H:i:s", $temposoma);
                $tempopause->save();
                
            }
            
            return redirect()->route($request->url_ver);

        }elseif($chamado->status_id == '1' || $chamado->status_id == '4'){
            if($this->checarAdm()){
                $chamado->status_id = $request->status_chamado;
            }elseif(!$this->checarAdm()){
                $chamado->status_id = '1';
            }
            $chat->user_id = session('id');
            $chat->chamado_id = $request->id_chamado;
            $chat->chat = 'iniciou o Atendimento!';
            $chat->inicio = '1';
            $chat->save();
            $chamado->save();

            $tempo->chamado_id = $chamado->id;
            $tempo->pausado = '0';
            $tempo->inicio = $databanco->format('Y/m/d H:i:s');
            $tempo->save();
            $tempopause = Tempo::where('chamado_id', '=', $request->id_chamado)->where('pausado', '=', '0')->first();
            session()->put('pause', $tempopause->pausado);
            return redirect()->route($request->url_ver);
        }
        else{
            session()->flash('id_Chat', $request->id_Chat);
            session()->flash('erroChat', 'Digite uma Mensagem!');
            return redirect()->route($request->url_ver);
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
    public function criar(UsuarioRequest $request)
    {
        $usuario = new User;
        $usuario ->name = $request->cria_nome;
        $usuario ->departamento = $request->dep_user;
        $usuario ->email = $request->cria_email;
        $usuario ->password = $request->senha;
        $usuario ->nivel = $request->nivel_user;

        $usuario->save();
        
        return redirect()->route('usuarios');
    }

    /* --------------------REDIRECIONAMENTOS----------------------- */

    /* Função para Redirecionameto do Painel Administrativo */
    public function painelAdm()
    {
        if($this->checarSessao() && $this->checarAdm()){
            $errorel = session('errorelacionameto');
            $relacionamentos = Relacionamento::all();
            $departamento = Departamento::all();
            $topicos = Topico::all();
            $data=[
                'errorelacionameto' => $errorel,
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
            $chatid = session('id_Chat');
            $name = session('name');
            $erro = session('erroChat');
            $departamento = session('departamento');
            $topicos = Topico::all();
            $usuarios = User::all();
            $chamado = Chamado::all();
            $chat = Interacoe::all();
            $tempo = Tempo::all();
            $relacionamentos = Relacionamento::all();
            
            $data = [
                'tempo' => $tempo,
                'chatid' => $chatid,
                'erroChat' => $erro,
                'relacionamentos' => $relacionamentos,
                'departamento' => $departamento,
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
            $erro = session('erroChat');
            $id = session('id');
            $chatid = session('id_Chat');
            $nivel = session('nivel');
            $departamento = session('departamento');
            $chamado = Chamado::all();
            $usuarios = User::all();
            $chat = Interacoe::all();
            $data = [
                'departamento' => $departamento,
                'nivel' => $nivel,
                'chatid' => $chatid,
                'erroChat' => $erro,
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

    public function finalizados()
    {
        if($this->checarSessao()){
            $erro = session('erroChat');
            $nivel = session('nivel');
            $id = session('id');
            $chatid = session('id_Chat');
            $departamento = session('departamento');
            $chamado = Chamado::all();
            $usuarios = User::all();
            $chat = Interacoe::all();
            $data = [
                'nivel' => $nivel,
                'departamento' => $departamento,
                'chatid' => $chatid,
                'erroChat' => $erro,
                'interacoes' => $chat,
                'chamado' => $chamado,
                'id' => $id,
                'usuarios'=> $usuarios
            ];
            return view('finalizados', $data);
        }else{
            return redirect()->route('loginUser');
        }
    }

    public function finalizadosAdm()
    {
        if($this->checarSessao()){
            $erro = session('erroChat');
            $id = session('id');
            $tempo = Tempo::all();
            $chatid = session('id_Chat');
            $chamado = Chamado::all();
            $usuarios = User::all();
            $chat = Interacoe::all();
            $data = [
                'tempo' => $tempo,
                'chatid' => $chatid,
                'erroChat' => $erro,
                'interacoes' => $chat,
                'chamado' => $chamado,
                'id' => $id,
                'usuarios'=> $usuarios
            ];
            return view('admin.finalizadosadm', $data);
        }else{
            return redirect()->route('loginUser');
        }
    }

    public function homeSup()
    {
        $name = session('name');

        $data = [
            'name' => $name,
        ];

        return view('supervisor.indexsup', $data);
    }
}

