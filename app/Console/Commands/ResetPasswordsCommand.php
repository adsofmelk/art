<?php



namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Hash;

class ResetPasswordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset de passwords de usuarios con numero de documento';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    	parent::__construct();
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {	
    	
    	echo "\nReset de passwords\n";
    	try{
    		$this->resetPasswords();
    		
    	} catch (Exception $e){
    		echo $e->getMessage();
    		return false;
    	}
        
    	echo "\nProceso finalizado \n\n";
    }
    
    
    public function resetPasswords(){
    	
                
    	
    	try{
    	    
    	    $usuarios = \App\User::get();
    	    
    		foreach ($usuarios as $row){
    		    DB::beginTransaction();
    		    
    		    $persona = \App\PersonasModel::find($row->personas_idpersonas);
    		    
    		    echo "\n".$persona->nombres . " " . $persona->apellidos. " -> ". $persona->documento . " ... ";
    		    
    		    $usuario = \App\User::find($row->id);
    		    
    		    $usuario->password = Hash::make($persona->documento);
    		    
    		    $usuario->save();
    		    
    		    echo "Password modificado";
    		    
    		    DB::commit();
    		}
    		
    		
    		
    		
    		return true;
    				
    	} catch (Exception $ex) {
    		
    		DB::rollBack();
    		return false;
    	}
    	
    }
    
    
    
}
