<?php

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
	if (Auth::guest()){
		return Redirect::to('/login');
	}else{
		return Redirect::to('/home');
	}
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group( ['middleware' => ['auth']], function() {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('personas', 'PersonasController');
    Route::resource('disciplinarios', 'disciplinarios\DSC_DisciplinariosController');
    Route::resource('dsc_tiposfalta', 'disciplinarios\DSC_TiposfaltaController');
    Route::resource('dsc_procesos', 'disciplinarios\DSC_ProcesosController');
    Route::get('buscarcontratacionporcedula/{term}','MrChispaContratacionesController@buscarContratacionxCedula');
    Route::get('detallecontratacion/{id}','MrChispaContratacionesController@obtenerDetalleContratacion');
    Route::get('obtenercampospruebas/{id}','MrChispaContratacionesController@obtenerCamposPruebas');
    
});
