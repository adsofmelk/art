<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\AuthPermissionCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CargaHistoricoCommand;
use App\Console\Commands\CargaUsuariosCommand;
use App\Console\Commands\ResetPasswordsCommand;
use App\Console\Commands\CerrarProcesosNoAmpliadosCommand;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [ 
            AuthPermissionCommand::class,
            CargaHistoricoCommand::class,
            CargaUsuariosCommand::class,
            ResetPasswordsCommand::class,
            CerrarProcesosNoAmpliadosCommand::class 
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule            
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->command ('cerrarprocesos:noampliados')->daily();
    }
    
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path ( 'routes/console.php' );
    }
}
