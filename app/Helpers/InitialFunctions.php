<?php

use App\Models\TypeDoc;
use App\Models\DocumentUserFiles;
use App\Models\DocumentUserSol;
use App\Models\AlertDocumentsExpired;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\updateDocuments;
use Illuminate\Support\Facades\DB;

function scriptInitial(){
        $arrayUsers = [];
        $usersActives = [];

        $usersActives = User::select('id')->where('statu_id', 1)->where('role_id', '!=', [1, 5])->get();

        foreach($usersActives->unique()->filter() as $usersActive){
            array_push($arrayUsers, $usersActive->id);
        }

        $idNotInclude = [];
        $documents = [];

        $documentsSiExpireds =  []; //docs q si expiran
        
        foreach(DB::table('type_docs')->select('id')->whereIn('role_id', [2, 3, 4])->where('expired', 1)->get() as $docType){
            array_push($documentsSiExpireds, $docType->id);
        }


        
        $documents = DocumentUserFiles::where('expired', 0)->whereIn('document_id', $documentsSiExpireds)->get() ?? [];
        
        $dateActual = Carbon::now()->format('Y-m-d');
        if(isset($documents) && !empty($documents) && count($documents) > 0){
            foreach($documents AS $key => $document){   

                if(isset($document->date_expired)){
                    $dataA = Carbon::parse($dateActual);
                    $dataAA = Carbon::parse($dateActual)->addMonth(1);
                    $dataE = Carbon::parse($document->date_expired);
                    if(
                        $dataE->toDateString() == $dataAA->toDateString() || 
                        $dataE->toDateString() == $dataA->toDateString() || 
                        $dataE->toDateString() < $dataA->toDateString() ||  
                        ($dataE->toDateString() > $dataA->toDateString() && $dataE->toDateString() < $dataAA->toDateString())    
                    ){
                        $isDocReqForUser = DocumentUserSol::where('user_id', DocumentUserFiles::select('user_id')->where('id', $document->id)->first()->user_id)->first()->isSol;
                        if(isset($isDocReqForUser) && !empty($isDocReqForUser) && $isDocReqForUser != 1){       
                            $alert = new AlertDocumentsExpired();
                            $alert->document_user_file_id = $document->id;
                            $alert->save();

                            if($alert){
                                DocumentUserFiles::where('id', $document->id)->update(['expired' => 1]);
                            }
                        }
                        
                    }
                }
            }
        }



        $dataAlerts = AlertDocumentsExpired::where('send_email', 0)->get() ?? [];
        if(isset($dataAlerts) && !empty($dataAlerts) && count($dataAlerts) > 0){
            foreach($dataAlerts AS $key => $dataAlert){
                $dataDocument = DocumentUserFiles::where('id', $dataAlert->document_user_file_id)->first() ?? '';
                if(isset($dataDocument) && !empty($dataDocument)){
                    $infoUser = User::where('id', $dataDocument->user_id)->whereIn('role_id', [2, 3])->where('statu_id', 1)->first() ?? '';
                    $arrayDocs = [];
                    if(isset($infoUser) && !empty($infoUser)){
                        $documentsUser = DocumentUserFiles::where('user_id', $infoUser->id)->where('expired', 1)->get() ?? [];
                        if(isset($documentsUser) && !empty($documentsUser) && count($documentsUser) > 0){
                            foreach($documentsUser AS $documentUser){
                                $infoDocs = TypeDoc::find($documentUser->document_id);
                                if(isset($infoDocs) && !empty($infoDocs)){
                                    array_push($arrayDocs, $infoDocs);
                                    AlertDocumentsExpired::where('id', $dataAlert->id)->update(['send_email' => 1]);
                                }
                            }
                        }
                        Mail::to($infoUser->email)->cc(env('MAIL_USERNAME', 'update@unitedfamilyhc.com'))->send(new updateDocuments($infoUser, $arrayDocs));
                    }
                }
            }
        }
        
        if(isset($dataNoSol) && !empty($dataNoSol) && count($dataNoSol) > 0){
            foreach($dataNoSol as $k => $DNS){
                $dataDocUser = DocumentUserFiles::where('user_id', $DNS->user_id)->where('document_id', $DNS->document_id)->first();
                if(isset($dataDocUser) && !empty($dataDocUser)){
                    AlertDocumentsExpired::where('document_user_file_id', $dataDocUser->id)->delete();
                }
            }
        }

    return 0;
}