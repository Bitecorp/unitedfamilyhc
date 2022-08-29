<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\DataFile;
use Jenssegers\Agent\Agent;
use App\Models\User;
use App\Models\Companies;
use App\Models\ConfirmationIndependent;

use App\Models\RegisterAttentions;
use App\Models\Units;
use App\Models\SalaryServiceAssigneds;
use App\Models\ConfigSubServicesPatiente;
use App\Models\Service;
use App\Models\SubServices;
use App\Models\GenerateDocuments1099;

function createFile($file, $titleFile, $base64 = false)
{

    if (!$base64) {
        $ext  = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        $mime_type = $file->getClientMimeType();

        if ($mime_type == "application/octet-stream") {
            return false;
        }
    } else {
        $ext  = 'png';
        $name = $titleFile . '.' . $ext;
        $mime_type = 'image/png';
    }

    $nameClean = '';
    $fullName = '';

    if (isset($titleFile) && !empty($titleFile) && $titleFile != '') {
        $nameClean = str_replace(' ', '_', $titleFile);
        if ($base64) {
            $fullName = $nameClean . "_" . time() . "." . $ext;
        } else {
            $fullName = $nameClean . "." . $ext;
        }
    } else {
        $nameClean = str_replace(' ', '_', pathinfo($name, PATHINFO_FILENAME));
        $fullName = $nameClean . "_" . time() . "." . $ext;
    }

    if ($base64) {
        $image = $file;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $fullName;
        $file = Storage::disk('public_files')->put($imageName, base64_decode($image), 'public');
        $url  = $imageName /* Storage::disk('public_files')->url($fullName ) */;
        $path = $imageName  /* Storage::disk('public_files')->url($fullName ) */;
    } else {
        $file = Storage::disk('public_files')->put($fullName, file_get_contents($file), 'public');
        $url  = $fullName  /* Storage::disk('public_files')->url($fullName ) */;
        $path = $fullName  /* Storage::disk('public_files')->url($fullName ) */;
    }

    /*
    $path = $file->store('public_files');

    Storage::setVisibility($path, 'public');

    $url      = Storage::url($path); */
    /* $api_url  = env("APP_URL");
    $api_port = env("APP_PORT");
    if(!is_null($api_port)){
        $url  = $api_url . ':' . $api_port . $url;
    }else{
        $url  = $api_url . $url;
    } */
    /*  $nameFile = explode("/",ltrim($url, "/")); */
    /* dd($nameFile[1]); */

    $new_file = DataFile::create([
        'name'      => $base64 ? $imageName : $fullName,
        'ext'       => $ext,
        'mime_type' => $mime_type,
        'path'      => $path,
        'url'       => $url,
    ]);
    $new_file->save();

    return $url;
}

function deleteFile($url)
{

    $file = DataFile::select('id', 'url')->where('url', $url)->first();

    if (!empty($file)) {
        $nameFile = explode("/", ltrim($url, "/"));
        Storage::disk('public_files')->delete($nameFile[0]);
        DataFile::destroy($file->id);
    }

    return true;
}

function sumaFechasTiempos ($fechaOne, $fechaTwo)
{
    $fechaOne = explode(':', $fechaOne);
    $fechaTwo = explode(':', $fechaTwo);

    $sh = intval($fechaOne[0]) + intval($fechaTwo[0]);
    $sm = intval($fechaOne[1]) + intval($fechaTwo[1]);
    $ss = intval($fechaOne[2]) + intval($fechaTwo[2]);

    $sumaTimes = $sh . ':' . $sm . ':' . $ss;

    $times = explode(':', $sumaTimes);

    if($times[0] < 10){
        if(isset(str_split($times[0])[1]) && !empty(str_split($times[0])[1])){
            $times[0] = str_split($times[0])[1];
        }else{
            $times[0] = $times[0];
        }
    }

    if($times[1] < 10){
        $times[1] = '0' . $times[1];
    }

    if($times[2] < 10){
        $times[2] = '0' . $times[2];
    }

    $timeU = $times[0] . ':' . $times[1] . ':' . $times[2];
    return $timeU;
}


function dataUser1099Global($idWorker){
    $dataEmpresa = '';
    $dataPersonal = User::where('id',$idWorker)->first();
    $confirm = ConfirmationIndependent::where('user_id', $idWorker)->where('independent_contractor', 1)->first() ?? '';
    if(isset($confirm) && !empty($confirm) && $confirm->personalEmpresa == 2){
        $dataEmpresa = Companies::where('user_id', $idWorker)->first();
        $dataEmpresa->user_id = User::where('id',$idWorker)->first();
    }

    if(isset($dataEmpresa) && !empty($dataEmpresa)){
        return $dataEmpresa;
    }else{
        return $dataPersonal;
    }
}

function dataPayUnitsServicesForWorker($worker_id, $patiente_id, $service_id, $sub_service_id, $fecha_desde, $fecha_hasta, $paid){
        $filters = [
            'service_id' => $service_id,
            'paid' => $paid,
            'sub_service_id' => $sub_service_id,
            'desde' => $fecha_desde,
            'hasta' => $fecha_hasta,
            'worker_id' => $worker_id,
            'patiente_id' => $patiente_id
        ];

        $registerAttentions = [];
        if($filters['service_id'] == 'all'){
            $dataTotal = RegisterAttentions::where('paid', $filters['paid'])->where('start', '>=', $filters['desde'])->where('end', '<=', $filters['hasta'])->get();
        }else{
            $dataTotal = RegisterAttentions::where('service_id', $filters['service_id'])
                ->where('paid', $filters['paid'])
                ->where('start', '>=', $filters['desde'])
                ->where('end', '<=', $filters['hasta'])->get();
        }

        $registerAttentions = $dataTotal->where('worker_id', $filters['worker_id']);
        
        $registerAttentionss = [];
        if(isset($registerAttentions) && !empty($registerAttentions) && count($registerAttentions) >= 1){
            foreach($registerAttentions as $registerAttention){

                $timeAttention = $registerAttention->start->diff($registerAttention->end);
                $times = explode(":", $timeAttention->format('%H:%i:%s'));

                if($times[0] < 10){
                    $times[0] = str_split($times[0])[1];
                }

                if($times[1] < 10){
                    $times[1] = '0' . $times[1];
                }

                if($times[2] < 10){
                    $times[2] = '0' . $times[2];
                }
                
                $registerAttention->time_attention = $times[0] . ':' . $times[1] . ':' . $times[2];

                array_push($registerAttentionss, $registerAttention);
            }
            
            $arrayCollect = collect($registerAttentionss)->unique();
            $arraySum = [];
            if(count($arrayCollect) > 1){
                foreach($arrayCollect as $keyI => $registerAttention){
                    $count = $arrayCollect
                        ->where('worker_id', $registerAttention->worker_id)
                        ->where('patiente_id', $registerAttention->patiente_id)
                        ->where('service_id', $registerAttention->service_id)
                        ->where('sub_service_id', $registerAttention->sub_service_id)
                    ;

                    if(count($count) > 1){
                        if(isset($count) && !empty($count) && count($count) >= 1){
                            foreach($count->where('id', '<>', $registerAttention->id) as $key => $registerAttent){
                                $registerAttention->time_attention = sumaFechasTiempos($registerAttention->time_attention, $registerAttent->time_attention);
                                array_push($arraySum, $registerAttention);
                                unset($arrayCollect[$key]);  
                            }                    
                        }
                    }elseif(count($count) == 1){
                        foreach($arrayCollect->where('id', $registerAttention->id) as $key => $registerAttent){
                            //$registerAttention->time_attention = sumaFechasTiempos($registerAttention->time_attention, $registerAttent->time_attention);
                            array_push($arraySum, $registerAttention);
                            unset($arrayCollect[$key]);  
                        }
                    }

                }
            }else{
                $arraySum = $registerAttentionss;
            }

            $arraySumClean = collect($arraySum)->unique()->filter();

            $arrayFinal = [];
            if(isset($arraySumClean) && !empty($arraySumClean) && count($arraySumClean) >= 1){
                foreach($arraySumClean as $arraySumC){
                    //array_push($dataInit, array($arraySumC->worker_id, $arraySumC->patiente_id, $arraySumC->service_id, $arraySumC->sub_service_id));

                    $dataWorker = User::find($arraySumC->worker_id);
                    $arraySumC->worker_id = $dataWorker;

                    $dataindependentContractor = ConfirmationIndependent::where('user_id', json_decode($arraySumC->worker_id)->id)->first();
                    if(isset($dataindependentContractor) && !empty($dataindependentContractor)){
                        $arraySumC->independent_contractor = $dataindependentContractor;
                    }

                    $dataPatiente = User::find($arraySumC->patiente_id);
                    $arraySumC->patiente_id = $dataPatiente;

                    $dataService = Service::find($arraySumC->service_id);
                    $arraySumC->service_id = $dataService;

                    $dataSubService = SubServices::find($arraySumC->sub_service_id);
                    $arraySumC->sub_service_id = $dataSubService;

                    $dataDocument1099 = GenerateDocuments1099::where('service_id', strval(json_decode($arraySumC->service_id)->id))
                            ->where('worker_id', strval(json_decode($arraySumC->worker_id)->id))
                            ->where('patiente_id', strval(json_decode($arraySumC->patiente_id)->id))
                            ->where('sub_service_id', strval(json_decode($arraySumC->sub_service_id)->id))
                            ->where('from', '>=', $filters['desde'])
                            ->where('to', '>=', $filters['hasta'])->first();
                    

                    if(isset($dataDocument1099) && !empty($dataDocument1099)){                         
                        if(isset($dataDocument1099->eftor_check) && !empty($dataDocument1099->eftor_check)){
                            $arraySumC->eftor_check = $dataDocument1099->eftor_check;
                        }else{
                            $arraySumC->eftor_check = '';
                        }

                        if(isset($dataDocument1099->invoice_number) && !empty($dataDocument1099->invoice_number)){
                            $arraySumC->invoice_number = $dataDocument1099->invoice_number;
                        }else{
                            $arraySumC->invoice_number = '';
                        }
                            
                    }else{
                        $arraySumC->eftor_check = '';
                        $arraySumC->invoice_number = '';
                    }                  

                    $dataPagosWorker = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $dataWorker->id)->first();

                    if(isset($dataPagosWorker) && !empty($dataPagosWorker)){
                        if(!isset($dataPagosWorker->salary) || empty($dataPagosWorker->salary)){
                            $dataPagosWorker->salary = $dataSubService->worker_payment;
                            $arraySumC->unit_value_worker = $dataPagosWorker->salary;
                        }else{
                            $arraySumC->unit_value_worker = $dataPagosWorker->salary;
                        }

                        $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataPagosWorker->id)->first();
                        
                        if(isset($dataConfig) && !empty($dataConfig)){
                            if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                                $dataUnidadConfig = Units::find($dataConfig->unit_id);
                                if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                                    $arraySumC->unidad_time_worker = $dataUnidadConfig->time;
                                    $arraySumC->unidad_type_worker = $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                    $arraySumC->unidad_type_worker_int = $dataUnidadConfig->type_unidad;
                                }
                            }else{
                                $dataUnidadWorker = Units::find($dataSubService->unit_worker_payment_id);
                                $arraySumC->unidad_time_worker = $dataUnidadWorker->time;
                                $arraySumC->unidad_type_worker = $dataUnidadWorker->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_worker_int = $dataUnidadWorker->type_unidad;
                            }
                        }else{
                            $dataUnidadWorker = Units::find($dataSubService->unit_worker_payment_id);
                            $arraySumC->unidad_time_worker = $dataUnidadWorker->time;
                            $arraySumC->unidad_type_worker = $dataUnidadWorker->type_unidad == 0 ? 'Minutes' : 'Hours';
                            $arraySumC->unidad_type_worker_int = $dataUnidadWorker->type_unidad;
                        }


                        $unidadesPorPagar = '';
                        $times = explode(":", $arraySumC->time_attention);
                        if($arraySumC->unidad_type_worker_int == 0){
                            $unidH = ($times[0] * 60) / $arraySumC->unidad_time_worker;
                            $unidM = $times[1] / $arraySumC->unidad_time_worker;

                            $calc = $unidH + $unidM;
                            $unidadesPorPagar = number_format((float)$calc, 2, '.', '');

                        }else{
                            $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_worker;
                            $unidadesPorPagar = number_format((float)$calc, 2, '.', '');
                        }
                        
                        $arraySumC->unid_pay_worker = $unidadesPorPagar;
                        $calcPay = $arraySumC->unid_pay_worker * $dataPagosWorker->salary;
                        $arraySumC->mont_pay = number_format((float)$calcPay, 2, '.', '');                        
                    }
                    array_push($arrayFinal, $arraySumC);
                }
            }
        }
    return collect($arrayFinal);
}

function generar1099($worker_id, $patiente_id, $service_id, $sub_service_id, $fecha_desde, $fecha_hasta, $paid, $eftor_check, $invoice_number){
    $filters = [
            'service_id' => $service_id,
            'paid' => $paid,
            'sub_service_id' => $sub_service_id,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
            'worker_id' => $worker_id,
            'patiente_id' => $patiente_id,
            'eftor_check' => $eftor_check,
            'invoice_number' => $invoice_number
        ];

    $dataWorker = dataUser1099Global(intval($filters['worker_id']));

    $dataPagos = dataPayUnitsServicesForWorker($filters['worker_id'], $filters['patiente_id'], $filters['service_id'], $filters['sub_service_id'], $filters['fecha_desde'], $filters['fecha_hasta'], 1);
        
    $arrayData = [
        'infoUser' => $dataWorker,
        'eftorCheck' => $filters['eftor_check'],
        'invoiceNumber' => $filters['invoice_number'],
        'desde' => date_format(date_create($filters['fecha_desde']), 'm/d/Y'),
        'hasta' => date_format(date_create($filters['fecha_hasta']), 'm/d/Y'),
        'datePai' => date("m/d/Y",strtotime(date_format(date_create($filters['fecha_hasta']), 'm/d/Y')."+ 1 days")),
        'dataPago' => $dataPagos
    ];

    return $arrayData;
}