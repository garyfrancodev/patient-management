<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class KafkaRunAllConsumers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kafka-run-all-consumers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
	    $this->info('Iniciando todos los consumidores...');

//	    $consumers = [
//		    'kafka:consume-orders',
//		    'kafka:consume-invoices',
//		    'kafka:consume-payments',
//	    ];
//
//	    foreach ($consumers as $command) {
//		    $this->info("Ejecutando: $command");
//		    $process = popen("php artisan $command &", "r");
//		    if ($process) {
//			    pclose($process);
//		    }
//	    }

	    $this->info('Todos los consumidores fueron lanzados en background.');
    }
}
