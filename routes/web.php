<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LdapController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*user*/
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth');
//Route::post('/user', [App\Http\Controllers\UserController::class, 'verificaEmail']);
Route::resource('user', 'App\Http\Controllers\UserController')->middleware('auth');

/*perfiles*/
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth');
Route::resource('profile', 'App\Http\Controllers\ProfileController')->middleware('auth');

/*permisos*/
Route::get('/permisos', [App\Http\Controllers\PermisosController::class, 'index'])->middleware('auth');
Route::resource('permisos', 'App\Http\Controllers\PermisosController')->middleware('auth');

/*config*/
Route::get('/configuracion', [App\Http\Controllers\ConfigController::class, 'index'])->middleware('auth');
Route::resource('configuracion', 'App\Http\Controllers\ConfigController')->middleware('auth');

/*ejecutivos*/
Route::get('/ejecutivos', [App\Http\Controllers\EjecutivosController::class, 'index'])->middleware('auth');
Route::resource('ejecutivos', 'App\Http\Controllers\EjecutivosController')->middleware('auth');

/*Contratos*/
Route::get('/contratos', [App\Http\Controllers\ContratoController::class, 'index'])->middleware('auth');
Route::resource('contratos', 'App\Http\Controllers\ContratoController')->middleware('auth');
Route::get('/contrato', 'App\Http\Controllers\ContratoController@contrato')->middleware('auth');


/*Servicios*/
Route::get('/servicios', [App\Http\Controllers\ServicioController::class, 'index'])->middleware('auth');
Route::resource('servicios', 'App\Http\Controllers\ServicioController')->middleware('auth');

/* LDAP */
Route::get('/ldap', [LdapController::class, 'index'])->name('ldap.index')->middleware('auth');
Route::post('/ldap/connect', [LdapController::class, 'connect'])->name('ldap.connect')->middleware('auth');
Route::get('/ldap/transfer', [LdapController::class, 'transferView'])->name('ldap.transfer.view')->middleware('auth');
Route::post('/ldap/transfer/users', [LdapController::class, 'transferUsers'])->name('ldap.transfer.users')->middleware('auth');

/*Peticiones Ajax*/
Route::post('/ajax', [App\Http\Controllers\AjaxController::class, 'index'])->name('ajax');
//Route::post('ajax', 'App\Http\Controllers\AjaxController');

// routes/web.php
