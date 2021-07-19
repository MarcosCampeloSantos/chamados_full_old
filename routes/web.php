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

Route::get('/', HomeController::class) -> name('login');

Route::get('/acompanhar', function () {
    return view('acompanhar');
});

Route::get('/criar', function () {
    return view('criar');
});

Route::get('/home', function () {
    return view('index');
}) -> name('home');

Route::get('/criar-user', function(){
    return view('admin.usuarios');
});

Route::post('home', [UsuarioController::class, 'login'])->name('logar.usuario');