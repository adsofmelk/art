<?php

use phpDocumentor\Reflection\Types\This;
use App\Helpers;

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
			
			$message->from('adsofmelk-29048c@inbox.mailtrap.io', 'Oscar M Borja');
			
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


///SOCIAL AUTH
    Route::get('auth/social', 'Auth\SocialAuthController@show')->name('social.login');
    Route::get('oauth/{driver}', 'Auth\SocialAuthController@redirectToProvider')->name('social.oauth');
    Route::get('oauth/{driver}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');

///FIN SOCIAL AUTH


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group( ['middleware' => ['auth']], function() {
	
	//DSC
	
	//PDFS
	Route::get('pdfcitaciondescargos/{id}','disciplinarios\DSC_DocumentosPDFController@citacionDescargos');
	Route::get('pdfactadescargos/{id}','disciplinarios\DSC_DocumentosPDFController@actaDescargos');
	Route::get('pdffallo/{id}','disciplinarios\DSC_DocumentosPDFController@falloProceso');
	// /. PDFS
	
	Route::get('listadopreguntasdescargos/{term}','disciplinarios\DSC_PreguntasdescargosController@buscarPreguntaxSubcadena');
	
	Route::get('archivodisciplinarios','disciplinarios\DSC_DisciplinariosController@indexArchivo');
	Route::get('ampliaciondisciplinarios','disciplinarios\DSC_DisciplinariosController@indexAmpliacion');
	Route::get('descargosdisciplinarios','disciplinarios\DSC_DisciplinariosController@indexDescargos');
	Route::get('actadescargosdisciplinarios','disciplinarios\DSC_DisciplinariosController@indexActaDescargos');
	Route::get('fallosdisciplinarios','disciplinarios\DSC_DisciplinariosController@indexFallos');
	Route::get('fallostemporalesdisciplinarios','disciplinarios\DSC_DisciplinariosController@indexFallosTemporales');
	
	Route::resource('disciplinarios', 'disciplinarios\DSC_DisciplinariosController');
	Route::resource('dsc_tiposfalta', 'disciplinarios\DSC_TiposfaltaController');
	
	Route::get('dsc_listarprocesos/{order}/{offset}/{limit}/{filter?}/{search?}/{nombreestadoproceso?}', 'disciplinarios\DSC_ProcesosController@listarProcesos');
	
	Route::get('dsc_fallostemporalesprocesos', 'disciplinarios\DSC_FallosController@getFallosTemporales');
	Route::resource('dsc_procesos', 'disciplinarios\DSC_ProcesosController');
	Route::resource('dsc_archivoprocesos', 'disciplinarios\DSC_ArchivoprocesosController');
	Route::resource('dsc_ampliacionprocesos', 'disciplinarios\DSC_AmpliacionController');
	Route::resource('dsc_descargosprocesos', 'disciplinarios\DSC_DescargosController');
	Route::resource('dsc_actadescargosprocesos', 'disciplinarios\DSC_ActaDescargosController');
	Route::resource('dsc_fallosprocesos', 'disciplinarios\DSC_FallosController');
	
	Route::resource('dsc_plantillas','disciplinarios\DSC_PlantillasController');
	
	
	Route::resource('dsc_evaluacionprocesos', 'disciplinarios\DSC_GestionprocesoController');
	Route::resource('ampliacionproceso', 'disciplinarios\DSC_AmpliacionController');
	Route::resource('descargos', 'disciplinarios\DSC_DescargosController');
	Route::resource('actadescargos', 'disciplinarios\DSC_ActaDescargosController');
	
	Route::get('editarfallo/{id}', 'disciplinarios\DSC_FallosController@editarFallo');
	Route::resource('fallos', 'disciplinarios\DSC_FallosController');
	
	//DSC FILES
	Route::get('dsc_file/{id}',function($id){
		
	    if(Storage::exists("dsc/" . $id )||Storage::exists("dsc/pruebasdescargos/" . $id )){
			
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
