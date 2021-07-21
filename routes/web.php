<?php

use App\Http\Controllers\HomeController;
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
Route::get('/criar', 'usuariocontroller@usuarios')->name('usuarios'); #Tela Criação de Usuario
Route::get('/chamados','usuariocontroller@chamado')->name('chamado'); #Tela Criação de Chamados
Route::get('/acompanhar','usuariocontroller@acompanharChamados')->name('acompanhar'); #Tela de acompanhamento de Chamados
Route::get('/homeAdm','usuariocontroller@homeAdm')->name('homeAdm'); #Tela de acompanhamento de Chamados
Route::get('/sair','usuariocontroller@sair')->name('sair'); #Deslogar do Usuario

#----POST-------
Route::post('criar_user', 'usuariocontroller@criar')->name('criar_user'); #Verificação de Criação de Usuario
Route::post('/login', 'usuariocontroller@login')->name('login'); #Verificação de Login
Route::post('chamadoCriar','usuariocontroller@chamadoCriar')->name('chamadoCriar'); #Criando Chamado