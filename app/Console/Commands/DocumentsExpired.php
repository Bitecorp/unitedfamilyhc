<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TypeDoc;
use App\Models\DocumentUserFiles;
use App\Models\AlertDocumentsExpired;
use Carbon\Carbon;

class DocumentsExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alertDocuments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Evalua los documentos expirados y coloca las alertas necesarias en la bd';

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
        $documents = DocumentUserFiles::where('expired', 0)->get();
        $dateActual = Carbon::now()->format('Y-m-d');
        $dateExpired = $document->date_expired->toDateString();
        foreach($documents AS $key => $document){
            if($dateExpired->addMonth(1) >= $dateActual){
                $alert = new AlertDocumentsExpired();
                $alert->document_user_file_id = $document->id;
                $alert->save();

                if($alert){
                    DocumentUserFiles::where('id', $document->id)->update(['expired' => 1]);
                }
            }
        }
        return 0;
    }
}
