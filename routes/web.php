<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
#----GET-------
Route::get('/', 'usuariocontroller@loginUser')->name('loginUser'); #Tela de Login
Route::get('/homeUser', 'usuariocontroller@homeUser')->name('homeUser'); #Tela Home Usuario
Route::get('/usuarios', 'usuariocontroller@usuarios')->name('usuarios'); #Tela Criação de Usuario
Route::get('/chamados','usuariocontroller@chamado')->name('chamado'); #Tela Criação de Chamados
Route::get('/acompanhar','usuariocontroller@acompanharChamados')->name('acompanhar'); #Tela de acompanhamento de Chamados
Route::get('/homeAdm','usuariocontroller@homeAdm')->name('homeAdm'); #Tela Home do Adm
Route::get('/sair','usuariocontroller@sair')->name('sair'); #Deslogar do Usuario
Route::get('/paineladm','usuariocontroller@painelAdm')->name('paineladm'); #Deslogar do Usuario
Route::get('/finalizados','usuariocontroller@finalizados')->name('finalizados'); #Tela de Chamados finalizados
Route::get('/finalizadosadm','usuariocontroller@finalizadosAdm')->name('finalizadosadm'); #Tela de Chamados finalizados
Route::get('/homeSup','usuariocontroller@homeSup')->name('homeSup'); #Tela Home do Supervisor
Route::get('/homeOp','usuariocontroller@homeOp')->name('homeOp'); #Tela Home do Operador

Route::get("/anexo/{file}", function ($file="") {
    return response()->download(public_path("anexos/".$file));
    });

#----POST-------
Route::post('/criar_user', 'usuariocontroller@criar')->name('criar_user'); #Verificação de Criação de Usuario
Route::post('/login', 'usuariocontroller@login')->name('login'); #Verificação de Login
Route::post('/chamadoCriar','usuariocontroller@chamadoCriar')->name('chamadoCriar'); #Criando Chamado
Route::post('/criardep','usuariocontroller@criarDep')->name('criardep'); #Criar Departamentos
Route::post('/criartop','usuariocontroller@criarTop')->name('criartop'); #Criar Topico de Atendimento
Route::post('/envchat','usuariocontroller@envChat')->name('envchat'); #Enviar mensagem no chat 'Lado do ADM ou Operador'
Route::post('/criar_rel','usuariocontroller@criarRel')->name('criar_rel'); #Criar Relacionamentro
Route::post('/editar_rel','usuariocontroller@editarRel')->name('editar_rel'); #Criar Relacionamentro