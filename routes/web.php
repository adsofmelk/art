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
	
	//DSC
	
	Route::resource('disciplinarios', 'disciplinarios\DSC_DisciplinariosController');
	Route::resource('dsc_tiposfalta', 'disciplinarios\DSC_TiposfaltaController');
	Route::resource('dsc_procesos', 'disciplinarios\DSC_ProcesosController');
	Route::resource('dsc_evaluacionprocesos', 'disciplinarios\DSC_GestionprocesoController');
	Route::resource('ampliacionproceso', 'disciplinarios\DSC_AmpliacionController');
	
	//DSC FILES
	Route::get('dsc_file/{id}',function($id){
		if(Storage::exists("dsc/" . $id )){
			$file = Storage::get("dsc/" . $id );
			if($prueba = \App\DSC_PruebasModel::find($id)){
				header('Content-type: ' . $prueba->mime);
				
				header('Content-Disposition: attachment; filename="ART_PD_'.$prueba->iddsc_pruebas.'@'.$prueba->dsc_procesos_iddsc_procesos.time().'.'.$prueba->extension.'"');
				echo $file;
			}else{
				header("HTTP/1.0 404 Not Found");
			}
			
		}else{
			header("HTTP/1.0 404 Not Found");
		}
	});
	
	
	// /.DSC
	
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('personas', 'PersonasController');
    
    
    Route::get('buscarcontratacionporcedula/{term}','MrChispaContratacionesController@buscarContratacionxCedula');
    Route::get('detallecontratacion/{id}','MrChispaContratacionesController@obtenerDetalleContratacion');
    Route::get('obtenercampospruebas/{id}','MrChispaContratacionesController@obtenerCamposPruebas');
    
});
