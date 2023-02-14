<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\RegisterAttentions;

class CreateDataNoteAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createDataNoteAmount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'llena la tabla de montos de las notas por si los valores por defecto o de configuracion cambian a las mismas no les cambie el valor de pago';

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
     * @return int
     */
    public function handle()
    { 
        $dataNotes = RegisterAttentions::all();

        foreach($dataNotes as $key => $dataNote){
            saveDataAmountNote($dataNote->id, $dataNote->worker_id, $dataNote->patiente_id, $dataNote->sub_service_id);
        }
    }
}
