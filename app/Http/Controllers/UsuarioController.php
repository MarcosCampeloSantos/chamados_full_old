<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UsuarioRequest;
use App\Http\Controllers\FiltroController;
use App\Mail\SendMails;
use App\Mail\SendMailsAdm;
use App\Mail\SendCriacaoMailAdm;
use App\Mail\SendCriacaoMail;
use App\Models\Atribuicoe;
use App\Models\User;
use App\Models\Chamado;
use App\Models\Tempo;
use App\Models\Topico;
use App\Models\Favorito;
use App\Models\Interacoe;
use App\Models\Relacionamento;
use App\Models\Departamento;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            }elseif(@$usuarios->nivel == '4'){
                return redirect()->route('homeOp');
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

    /* Função para Arquivar Chamados */
    public function arquivo(Request $request)
    {

        if(!Favorito::where('user_id', '=', session('id'))->where('chamado_id', '=', $request->id_chamado)->first()){
            $favoritos = new Favorito;
            $favoritos->chamado_id = $request->id_chamado;
            $favoritos->user_id = session('id');

            $favoritos->save();
        }else{
            session()->flash('errofinaladm', 'Chamado já Foi Arquivado');
        }
        return redirect()->route('finalizadosadm');
    }

    /* Função para Criando Relacionamentos */
    public function criarRel(Request $request)
    {  
        $atribuicao = new Atribuicoe;
        $user = User::where('id', '=', $request->rel_user)->first();
        $relacionamentos = new Relacionamento;
        if(!Relacionamento::where('departamentos_id', '=', $request->rel_dep)->where('topicos_id', '=', $request->rel_top)->first()){
            $relacionamentos->departamentos_id = $request->rel_dep;
            $relacionamentos->topicos_id = $request->rel_top;
            $relacionamentos->save();

            $atribuicao->id_user = $user->id;
            $atribuicao->id_relacionamento = $relacionamentos->id;
            $atribuicao->save();
        }else{
            session()->flash('errorelacionameto', 'Relacionamento já Existe');
        }
        return redirect()->route('paineladm');

        
    }

    /* Função para Editar Relacionamento */
    public function editarRel(Request $request)
    {
        $idrel = $request->id_relacionamento;
        $atribuicao = new Atribuicoe;
        $user = User::where('id', '=', $request->rel_user_edit)->first();
        $rel = Relacionamento::where('id', '=', $idrel )->first();
        if ($rel->id == $idrel && !Relacionamento::where('departamentos_id', '=', $request->rel_dep)->where('topicos_id', '=', $request->rel_top)->first()) {
            $rel->departamentos_id = $request->rel_dep;
            $rel->topicos_id = $request->rel_top;
            $rel->save();
            if(isset($user->id)){
                $atribuicao->id_user = $user->id;
                $atribuicao->id_relacionamento = $rel->id;
                $atribuicao->save();
            }
            

            return redirect()->route('paineladm');
        }else{
            session()->flash('errorelacionameto', 'Relacionamento já Existe');
            return redirect()->route('paineladm');
        }
    }

    /* Função para Atribuir Ralacionamento a Operador/Adm */
    public function adicionarAtributo(Request $request)
    {
        if (!Atribuicoe::where('id_relacionamento', '=', $request->id_relacionamento)->where('id_user', '=', $request->rel_user_edit)->first()) {
            $atributo = new Atribuicoe();
            $atributo->id_user = $request->rel_user_edit;
            $atributo->id_relacionamento = $request->id_relacionamento;
            $atributo->save();

            return redirect()->route('paineladm');
        }else{
            session()->flash('errorelacionameto', 'Usuario já foi Atibuido a este Relacionamento!');
            return redirect()->route('paineladm');
        }
        
    }

    /* Função para Criar os Departamentos */
    public function criarDep(Request $request)
    {
        $departamento = new Departamento;
        if(!empty($request->cria_dep) || !empty($request->cria_dep_email)){
            $departamento->departamento = $request->cria_dep;
            $departamento->menssageremail = $request->cria_dep_email;

            $departamento->save();
        }else{
            session()->flash('errorelacionameto', 'Por favor Preencha todos os Campos!');
        }
        return redirect()->route('paineladm');
    }

    /* Função para Criar Chamados*/
    public function chamadoCriar(Request $request)
    {
        $chamado = new Chamado;
        $chat = new Interacoe;
        $user = User::where('id', '=', session('id'))->first();

        $chamado->departamento = session('departamento');
        $chamado->status_id = '1';
        $chamado->IP = $_SERVER['REMOTE_ADDR'];
        $chamado->title = $request->titulo;
        $chamado->topico = $request->topico;
        $chamado->name = session('name');
        $chamado->user_id = session('id');

        $chamado->save();

        if(!empty($request->anexo)){
            $requestarquivo = $request->anexo;
            $nomearquivo = $requestarquivo->getClientOriginalName();
            $request->anexo->move(public_path('anexos'), $nomearquivo);

            $chat->anexo = $nomearquivo;
            $chat->nameanexo = $requestarquivo->getClientOriginalName();
        }
        
        $chat->user_id = session('id');
        $chat->chat = $request->conteudo;
        $chat->chamado_id = $chamado->id;

        $chat->save();


        /* Notificação de Criação de Chamado */
        $enviochamado = Chamado::where('id', '=', $chamado->id)->first();
        $departamento = Departamento::where('id', '=', $enviochamado->departamento)->first();

        Mail::send(new SendCriacaoMailAdm($user, $request->conteudo, $chamado->id, $departamento->menssageremail, $chamado->title)); /* Notificação no E-mail Operados/Adm */
        Mail::send(new SendCriacaoMail($user, $request->conteudo, $chamado->id, $chamado->title)); /* Notificação no E-mail Usuario */

        return redirect()->route('homeAdm');
    }

    /* Função para Envio de mensagens nos Chamados */
    public function envChat(Request $request)
    {
        $chamado = Chamado::where('id', '=', $request->id_chamado)->first();
        $user = User::where('id', '=', $chamado->user_id)->first();
        $userOp = User::where('id', '=', session('id'))->first();
        $departamento = Departamento::where('id', '=', $chamado->departamento)->first();
        $chat = new Interacoe;
        $tempo = new Tempo;
        $databanco = new DateTime(date('Y/m/d H:i:s'));
        $tempopause = Tempo::where('chamado_id', '=', $request->id_chamado)->where('pausado', '=', '0')->first();
        $temposoma = 0;

        /* Verificação se Exite mensagem e Anexo Caso não Retorna Erro*/
        if (!empty($request->chat)) {
            if($this->checarAdm()){
                $chamado->status_id = $request->status_chamado;
            }elseif(!$this->checarAdm() && $chamado->status_id == '2'){
                $chamado->status_id = '1';
            }

            if(!empty($request->anexo)){
                $requestarquivo = $request->anexo;
                $nomearquivo = $requestarquivo->getClientOriginalName();
                $request->anexo->move(public_path('anexos'), $nomearquivo);
    
                $chat->anexo = $nomearquivo;
                $chat->nameanexo = $requestarquivo->getClientOriginalName();
            }

            /* Envio de Mensagem no Chat */
            $chat->user_id = session('id');
            $chat->chamado_id = $request->id_chamado;
            $chat->chat = $request->chat;

            $chat->save();
            $chamado->save();
            
            Mail::send(new SendMailsAdm($user, $request->chat, $chamado->id, $departamento->menssageremail)); /* Notificação no E-mail Operados/Adm */
            Mail::send(new SendMails($user, $request->chat, $chamado->id)); /* Notificação no E-mail Usuario */

            /* Logica para contagem do Tempo de Atendimento do Chamado */
            if($chamado->status_id == '4'){
                if($userOp->id_chamado != NULL){
                    $tempopause->termino = $databanco->format('Y/m/d H:i:s');
                    $tempopause->pausado = '1';
                    $tempopause->save();
        
                    $diferenca = strtotime($tempopause->termino) - strtotime($tempopause->inicio);
        
                    $tempopause->tempototal = gmdate("H:i:s", $diferenca);
                    $tempopause->save();

                    $userOp->id_chamado = NULL;
                    $userOp->save();

                    session()->put('pause', $tempopause->pausado);
                }else{
                    session()->flash('erroChat', 'Você já esta Atendendo o chamado #'.$userOp->id_chamado);
                }
                
            }elseif($chamado->status_id == '2'){
                if($userOp->id_chamado != NULL){
                    $tempopause->termino = $databanco->format('Y/m/d H:i:s');
                    $tempopause->save();
        
                    $diferenca = strtotime($tempopause->termino) - strtotime($tempopause->inicio);

                    $userOp->id_chamado = NULL;
                    $userOp->save();
        
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
                }else{
                    session()->flash('erroChat', 'Você já esta Atendendo o chamado #'.$userOp->id_chamado);
                }
                
            }
        }elseif($chamado->status_id == '1' || $chamado->status_id == '4'){
            if($this->checarAdm()){
                $chamado->status_id = $request->status_chamado;
            }elseif(!$this->checarAdm()){
                $chamado->status_id = '1';
            }

            if($userOp->id_chamado == NULL){
                $chat->user_id = session('id');
                $chat->chamado_id = $chamado->id;
                $chat->chat = 'iniciou o Atendimento!';
                $chat->inicio = '1';
                $chat->save();
                $chamado->save();

                $userOp->id_chamado = $chamado->id;
                $userOp->save();

                $tempo->chamado_id = $chamado->id;
                $tempo->pausado = '0';
                $tempo->inicio = $databanco->format('Y/m/d H:i:s');
                $tempo->save();
                $tempopause = Tempo::where('chamado_id', '=', $request->id_chamado)->where('pausado', '=', '0')->first();
                session()->put('pause', $tempopause->pausado);
            }else{
                session()->flash('erroChat', 'Você já esta Atendendo o chamado #'.$userOp->id_chamado);
            }
        }
        else{
            session()->flash('id_Chat', $request->id_Chat);
            session()->flash('erroChat', 'Digite uma Mensagem!');
        }

        session()->flash('id_Chat', $request->id_Chat);
        return redirect()->route($request->url_ver);
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

    /* Função para Checar se é um Operador*/
    public function checarOp()
    {
        if(session('nivel') == '4'){
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
            $users = User::all();
            $atribuicao = Atribuicoe::all();
            $relacionamentos = Relacionamento::all();
            $departamento = Departamento::all();
            $topicos = Topico::all();
            $data=[
                'atribuicao' => $atribuicao,
                'users' => $users,
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
    public function homeAdm(Request $request)
    {
        if($this->checarSessao() && $this->checarAdm()){
            $user_id = session('id');
            $chatid = session('id_Chat');
            $name = session('name');
            $erro = session('erroChat');
            $departamento = session('departamento');
            $atribuicao = Atribuicoe::all();
            $topicos = Topico::all();
            $usuarios = User::all();
            $chat = Interacoe::all();
            $tempo = Tempo::all();
            $relacionamentos = Relacionamento::all();

            $chamados = new Chamado;
            if(empty($request->search)){
                $limpafiltro = false;
                $chamado = Chamado::all();
            }else{
                $limpafiltro = true;
                $chamado = $chamados->pesquisa($request->search);
            }

            $contagemalladm = 0;
            $chamadosalladm = array();
            foreach ($chamado as $key) {
                if ($key->status_id != '2') {
                    array_push($chamadosalladm, $key);
                    $contagemalladm = $contagemalladm + 1;
                }
            }

            $contagemadpadm = 0;
            $chamadosdpadm = array();
            foreach ($chamado as $key) {
                foreach($relacionamentos as $key2){
                    if ($key2->topicos_id == $key->topico && $key->status_id != '2') {
                        if ($key2->departamentos_id == $departamento) {
                            array_push($chamadosdpadm, $key);
                            $contagemadpadm = $contagemadpadm + 1;
                        }
                    }
                }
            }

            $contagematributoadm = 0;
            $chamadosatributoadm = array();
            foreach ($chamado as $key) {
                foreach($relacionamentos as $key2){
                    if ($key2->topicos_id == $key->topico) {
                        foreach ($atribuicao as $key3) {
                            if ($key2->id == $key3->id_relacionamento && $key3->id_user == $user_id && $key->status_id != '2') {
                                array_push($chamadosatributoadm, $key);
                                $contagematributoadm = $contagematributoadm + 1;
                            }
                        }
                       
                    }
                }
            }
            
            $data = [
                'limpafiltro' => $limpafiltro,
                'contagemalladm' => $contagemalladm,
                'chamadosalladm' => $chamadosalladm,
                'contagematributoadm' => $contagematributoadm,
                'chamadosatributoadm' => $chamadosatributoadm,
                'contagemadpadm' => $contagemadpadm,
                'chamadosdpadm' => $chamadosdpadm,
                'atribuicao' => $atribuicao,
                'user_id' => $user_id,
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

    /* Função para Redirecionameto da Tela Home do Operador */
    public function homeOp(Request $request)
    {
        if($this->checarSessao() && $this->checarAdm() || $this->checarSessao() && $this->checarOp()){
            $user_id = session('id');
            $chatid = session('id_Chat');
            $name = session('name');
            $erro = session('erroChat');
            $nivel = session('nivel');
            $departamento = session('departamento');
            $atribuicao = Atribuicoe::all();
            $topicos = Topico::all();
            $usuarios = User::all();
            $chat = Interacoe::all();
            $tempo = Tempo::all();
            $relacionamentos = Relacionamento::all();

            $chamados = new Chamado;
            if(empty($request->search)){
                $limpafiltro = false;
                $chamado = Chamado::all();
            }else{
                $limpafiltro = true;
                $chamado = $chamados->pesquisa($request->search);
            }

            $contagemadpop = 0;
            $chamadosdpop= array();
            foreach ($chamado as $key) {
                foreach($relacionamentos as $key2){
                    if ($key2->topicos_id == $key->topico && $key->status_id != '2') {
                        if ($key2->departamentos_id == $departamento) {
                            array_push($chamadosdpop, $key);
                            $contagemadpop = $contagemadpop + 1;
                        }
                    }
                }
            }

            $contagematributoop = 0;
            $chamadosatributoop = array();
            foreach ($chamado as $key) {
                foreach($relacionamentos as $key2){
                    if ($key2->topicos_id == $key->topico) {
                        foreach ($atribuicao as $key3) {
                            if ($key2->id == $key3->id_relacionamento && $key3->id_user == $user_id && $key->status_id != '2') {
                                array_push($chamadosatributoop, $key);
                                $contagematributoop = $contagematributoop + 1;
                            }
                        }
                       
                    }
                }
            }
            
            $data = [
                'limpafiltro' => $limpafiltro,
                'contagematributoop' => $contagematributoop,
                'chamadosatributoop' => $chamadosatributoop,
                'contagemadpop' => $contagemadpop,
                'chamadosdpop' => $chamadosdpop,
                'user_id' => $user_id,
                'atribuicao' => $atribuicao,
                'nivel' => $nivel,
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
            return view('operador.indexoperador', $data);
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

    /* Função para Redirecionameto da Tela de Chamados Finalizados do Usuario */
    public function finalizados()
    {
        if($this->checarSessao()){
            $erro = session('erroChat');
            $nivel = session('nivel');
            $id = session('id');
            $chatid = session('id_Chat');
            $departamento = session('departamento');
            $topicos = Topico::all();
            $chamado = Chamado::all();
            $usuarios = User::all();
            $chat = Interacoe::all();
            $data = [
                'topicos' => $topicos,
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

    /* Função para Redirecionameto da Tela de Chamados Finalizados do Operador/Adm */
    public function finalizadosAdm(Request $request)
    {
        if($this->checarSessao()){
            $erro = session('erroChat');
            $chatid = session('id_Chat');
            $id = session('id');
            $errofinaladm = session('errofinaladm');
            $favoritos = Favorito::all();
            $tempo = Tempo::all();
            $chamado = Chamado::all();
            $topicos = Topico::all();
            $usuarios = User::all();
            $chat = Interacoe::all();

            $chamados = new Chamado;
            if(empty($request->search)){
                $limpafiltro = false;
                $chamado = Chamado::all();
            }else{
                $limpafiltro = true;
                $chamado = $chamados->pesquisaFim($request->search);
            }

            $contfinaladm = 0;
            $finaladm = array();
            foreach ($chamado as $key) {
                if($key->status_id == '2'){
                    array_push($finaladm, $key);
                    $contfinaladm = $contfinaladm + 1;
                }
            }

            $contfinaladmarc = 0;
            $finaladmarc = array();
            foreach ($chamado as $key) {
                foreach ($favoritos as $key2) {
                    if($key->id == $key2->chamado_id && $key2->user_id == $id && $key->status_id == '2'){
                        array_push($finaladmarc, $key);
                        $contfinaladmarc = $contfinaladmarc + 1;
                    }
                }
            }

            $data = [
                'limpafiltro' => $limpafiltro,
                'errofinaladm' => $errofinaladm,
                'contfinaladmarc' => $contfinaladmarc,
                'finaladmarc' => $finaladmarc,
                'finaladm' => $finaladm,
                'contfinaladm' => $contfinaladm,
                'topicos' => $topicos,
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

    /* Função para Redirecionameto da Tela do Supervisor de Departamento*/
    public function homeSup()
    {
        $name = session('name');

        $data = [
            'name' => $name,
        ];

        return view('supervisor.indexsup', $data);
    }
}

