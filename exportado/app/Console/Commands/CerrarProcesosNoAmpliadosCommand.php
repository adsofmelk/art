<?php



namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class CerrarProcesosNoAmpliadosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cerrarprocesos:noampliados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerrar procesos no ampliados despues de 48 horas';
    protected $detalleproceso = 'Cierre Automatico por superar plazo de 48 horas para adjuntar pruebas del proceso';
    
    protected $diasrestriccion;
    protected $estadoproceso;
    protected $gestor_id;
    protected $motivocierre;
    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    	parent::__construct();
    	$this->diasrestriccion = 2; //DIAS RESTRICCION CIERRE
    	$this->estadoproceso = 3;
    	$this->gestor_id = 'RRE6wj4pgRQorX5UAzxUB1wv8IqFc2hJCljT'; // ARCIVO BRM
    	$this->motivocierre = "Cierre del proceso por superar ". ($this->diasrestriccion * 24) . " horas sin adjuntar las pruebas requeridas";
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {	
    	
        echo "\nCerrar procesos con mas de  ".$this->diasrestriccion." días en estado \"Requiere Ampliación\"\n";
        
    	$procesos = \App\DSC_ProcesosModel::where(DB::raw('datediff(now(),updated_at )'),'>',$this->diasrestriccion) 
    	   ->where('dsc_estadosproceso_iddsc_estadosproceso','=',$this->estadoproceso)
    	   ->orderby('consecutivo','DESC')
    	   ->get();
    	
        if($procesos){
            foreach($procesos as $row){
                $this->desactivarProceso($row);
            }
        }else{
            echo "\nNo se encuentran procesos para archivar. Proceso finalizado\n\n";
            return;
        }
        echo "\n".sizeof($procesos)." archivados\n";
        
    }
    
    public function desactivarProceso($row){
       
        echo "Proceso " . $row->consecutivo;
        
        try {
            DB::beginTransaction();
            
            $proceso = \App\DSC_ProcesosModel::find($row->iddsc_procesos);
            
            $proceso->dsc_estadosproceso_iddsc_estadosproceso = 2; ///ARCHIVADO
            
            $proceso->dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion= 3; ///TIPO DE DESICION DE EVALUACION : ARCHIVO PROCESO
            
            $proceso->save();
            
            $datosgestion = [
                    'detalleproceso' => $this->detalleproceso,
                    'retirotemporal' => 0,
                    'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 3,
                    'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => 1,
                    'dsc_procesos_iddsc_procesos' => $row->iddsc_procesos,
                    'gestor_id' => $this->gestor_id,
                    'dsc_estadosproceso_iddsc_estadosproceso' => 2,
                    'dsc_tipogestion_iddsc_tipogestion' => 1,
            ];
            
            \App\DSC_GestionprocesoModel::create($datosgestion);
            
            \App\Helpers::emailInformarEstadoProceso($row->iddsc_procesos , $this->motivocierre);
            
            DB::commit();
            echo " ... OK\n";
        } catch (Exception $e) {
            
            DB::rollBack();
            echo " ... FAILL\n";
        }
        
       
    }
    
}
