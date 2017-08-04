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

// TEST DE PDF

Route::get('testpdf',function(){
	$pdf = App::make('dompdf.wrapper');
	$pdf->loadHTML('<h1>Test</h1>');
	return $pdf->stream();
});


Route::get('test2pdf',function(){
	$view =  \View::make('disciplinarios.plantillaspdf.renuncia_tacita',[
			'dia'=>date('d'),
			'mes'=>date('M'),
			'anio'=>date('Y'),
			'nombre'=>'nombre',
			'diarenuncia'=>'diarenuncia',
			'mesrenuncia'=>'mesrenuncia',
			'aniorenuncia'=>'aniorenuncia',
	])->render();
	$pdf = \App::make('dompdf.wrapper');
	$pdf->loadHTML($view);
	return $pdf->stream('invoice2');
});


// /. TEST DE PDF

//TEST DE CORREOS

	
	Route::get('enviar', ['as' => 'enviar', function () {
		
		$data = ['link' => 'http://styde.net'];
		
		\Mail::send('emails.notificacion', $data, function ($message) {
			
			$message->from('adsofmelk-29048c@inbox.mailtrap.io', 'OScar M Borja');
			
			$message->to('adsofmelk@gmail.com')->subject('Notificación');
			
		});
			
			return "Se envío el email";
	}]);
	
// /. TEST DE CORREOS

	
	
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
	
	Route::get('listadopreguntasdescargos/{term}','disciplinarios\DSC_PreguntasdescargosController@buscarPreguntaxSubcadena');
	
	Route::get('archivodisciplinarios','disciplinarios\DSC_DisciplinariosController@indexArchivo');
	Route::resource('disciplinarios', 'disciplinarios\DSC_DisciplinariosController');
	Route::resource('dsc_tiposfalta', 'disciplinarios\DSC_TiposfaltaController');
	Route::resource('dsc_procesos', 'disciplinarios\DSC_ProcesosController');
	Route::resource('dsc_archivoprocesos', 'disciplinarios\DSC_ArchivoprocesosController');
	Route::resource('dsc_evaluacionprocesos', 'disciplinarios\DSC_GestionprocesoController');
	Route::resource('ampliacionproceso', 'disciplinarios\DSC_AmpliacionController');
	Route::resource('descargos', 'disciplinarios\DSC_DescargosController');
	Route::resource('actadescargos', 'disciplinarios\DSC_ActaDescargosController');
	Route::resource('fallos', 'disciplinarios\DSC_FallosController');
	
	//DSC FILES
	Route::get('dsc_file/{id}',function($id){
		if(Storage::exists("dsc/" . $id )){
			
			if($prueba = \App\DSC_PruebasModel::find($id)){
				
				if($prueba->dsc_estadosprueba_iddsc_estadosprueba == 4){
					$file = Storage::get("dsc/pruebasdescargos/" . $id );
				}else{
					$file = Storage::get("dsc/" . $id );
				}
				
				
				
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
