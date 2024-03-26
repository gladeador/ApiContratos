<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\TeEventController;

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

/* Aquí te lleva a servicios */
Route::get('/contrato/servicios', function () {
    return redirect('/servicios');
});
/* Aquí te lleva a contratos */
Route::get('/contrato/contratos', function () {
    return redirect('/contratos');
});

Route::get('/webhook', function () {
    return view('webhook');
});

Auth::routes();

Route::get('/test' ,[App\Http\Controllers\TeEventController::class , 'testingEvents']);

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
//Route::get('/contratoss', 'App\Http\Controllers\ContratoController@index')->middleware('auth');
Route::resource('contratoss', 'App\Http\Controllers\ContratoController')->middleware('auth');
Route::get('/contrato/{organizacion_id}', 'App\Http\Controllers\ContratoController@contrato')->middleware('auth');
Route::get('/servicio/{contrato_id}/{organizacion_id}', 'App\Http\Controllers\ServicioController@servicio')->name('servicio')->middleware('auth');
Route::get('/contratoredireccion/{contrato_id}/{organizacion_id}', 'App\Http\Controllers\ContratoController@contratoredireccion')->middleware('auth');
Route::get('/contratoredireccionDos/{contrato_id}/{organizacion_id}', 'App\Http\Controllers\ContratoController@contratoredireccionDos')->middleware('auth');
Route::get('editaContrato/{id}', 'App\Http\Controllers\ContratoController@showForm')->name('contrato.editar.formulario')->middleware('auth');
Route::get('/show/{contrato_id}/{organizacion_id}', 'App\Http\Controllers\ContratoController@show')->middleware('auth');

/*Servicios*/
///Route::get('/servicios', [App\Http\Controllers\ServicioController::class, 'index'])->middleware('auth');
Route::resource('/servicios', 'App\Http\Controllers\ServicioController')->middleware('auth');
Route::get('/servicio', 'App\Http\Controllers\ServicioController@servicio')->middleware('auth');
Route::get('editaSerivico/{id}', 'App\Http\Controllers\ServicioController@showForm')->name('contrato.editar.servicio')->middleware('auth');
    
/* Horas Adicionales Contratos */
Route::resource('/horasadicionelescontrato', 'App\Http\Controllers\HorasAdicionalesContratoController')->middleware('auth');

/* Horas Adicionales Servicios */
Route::resource('/horasadicionelesservicio', 'App\Http\Controllers\HorasAdicionalesServiciosController')->middleware('auth');

/* LDAP */
Route::get('/ldap', [LdapController::class, 'index'])->name('ldap.index')->middleware('auth');
Route::post('/ldap/connect', [LdapController::class, 'connect'])->name('ldap.connect')->middleware('auth');
Route::get('/ldap/transfer', [LdapController::class, 'transferView'])->name('ldap.transfer.view')->middleware('auth');
Route::post('/ldap/transfer/users', [LdapController::class, 'transferUsers'])->name('ldap.transfer.users')->middleware('auth');

/*Peticiones Ajax*/
Route::post('/ajax', [App\Http\Controllers\AjaxController::class, 'index'])->name('ajax')->middleware('auth');
Route::get('/ajax', [App\Http\Controllers\AjaxController::class, 'index'])->name('ajax')->middleware('auth');
//Route::post('ajax', 'App\Http\Controllers\AjaxController');

/* App Webhook */
Route::post('/webhook/zammad', 'App\Http\Controllers\ZammadWebhookController@handle');


