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
use App\Models\NotesSubServicesRegister;
use App\Models\ReasonMemo;
use App\Models\documentsEditors;
use App\Models\PatientesAssignedWorkers;
use App\Models\ReasonMemoForPai;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;

class MyPdf extends \TCPDF
{
    protected $headerCallback;

    protected $footerCallback;

    public function Header()
    {
        if ($this->headerCallback != null && is_callable($this->headerCallback)) {
            $cb = $this->headerCallback;
            $cb($this);
        } else {
            //if (Config::get('tcpdf.use_original_header')) {
            //parent::Header();
            //}
            if (Config::get('tcpdf.use_original_header')) {
                // Get the current page break margin
                $bMargin = $this->getBreakMargin();

                // Get current auto-page-break mode
                $auto_page_break = $this->AutoPageBreak;

                // Disable auto-page-break
                $this->SetAutoPageBreak(false, 0);

                // Define the path to the image that you want to use as watermark.
                $img_file = Config::get('tcpdf.image_background');
                // Render the image
                $this->Image($img_file, 0, 0, 210, 295, '', '', '', false, 300, '', false, false, 0);

                // Restore the auto-page-break status
                $this->SetAutoPageBreak($auto_page_break, $bMargin);

                // set the starting point for the page content
                $this->setPageMark();
            }
        }
    }

    public function Footer()
    {
        if ($this->footerCallback != null && is_callable($this->footerCallback)) {
            $cb = $this->footerCallback;
            $cb($this);
        } else {
            //if (Config::get('tcpdf.use_original_footer')) {
            //parent::Footer();
            //}
            if (Config::get('tcpdf.use_original_footer')) {
                $this->setX(180);
                // Set font
                $this->SetFont('helvetica', 'I', 8);

                // Page number
                $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
        }
    }

    public function setHeaderCallback($callback)
    {
        $this->headerCallback = $callback;
    }

    public function setFooterCallback($callback)
    {
        $this->footerCallback = $callback;
    }

    public function addTOC($page = '', $numbersfont = '', $filler = '.', $toc_name = 'TOC', $style = '', $color = array(0, 0, 0))
    {
        // sort bookmarks before generating the TOC
        parent::sortBookmarks();

        parent::addTOC($page, $numbersfont, $filler, $toc_name, $style, $color);
    }

    public function addHTMLTOC($page = '', $toc_name = 'TOC', $templates = array(), $correct_align = true, $style = '', $color = array(0, 0, 0))
    {
        // sort bookmarks before generating the TOC
        parent::sortBookmarks();

        parent::addHTMLTOC($page, $toc_name, $templates, $correct_align, $style, $color);
    }
}

function url_actual()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } else {
        $url = "http://";
    }
    return $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
}

function allReason()
{
    return ReasonMemo::all() ?? [] ;
}

function infoService($id, $dato = null)
{
    if(isset($dato)){
        if($dato == 'name'){
            return Service::find($id)->name_service;
        }
    }else{
        return Service::find($id);
    }
}

function infoSubService($id, $dato = null)
{
    if(isset($dato)){
        if($dato == 'name'){
            return SubServices::find($id)->name_sub_service;
        }
    }else{
        return SubServices::find($id);
    }
}

function infoUser($id, $dato = null)
{
    if(isset($dato)){
        if($dato == 'fullName'){
            return User::find($id)->first_name .' '. User::find($id)->last_name;
        }
    }else{
        return User::find($id);
    }
}

function encriptar($st)
{
    return Crypt::encryptString($st);
}

function desencriptar($st)
{
    return Crypt::decryptString($st);
}

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

function sumaFechasTiempos($fechaOne, $fechaTwo)
{
    $fechaOne = explode(':', $fechaOne);
    $fechaTwo = explode(':', $fechaTwo);

    $sh = intval($fechaOne[0]) + intval($fechaTwo[0]);
    $sm = intval($fechaOne[1]) + intval($fechaTwo[1]);
    $ss = intval($fechaOne[2]) + intval($fechaTwo[2]);

    $sumaTimes = $sh . ':' . $sm . ':' . $ss;

    $times = explode(':', $sumaTimes);

    if ($times[0] < 10) {
        if (isset(str_split($times[0])[1]) && !empty(str_split($times[0])[1])) {
            $times[0] = str_split($times[0])[1];
        } else {
            $times[0] = $times[0];
        }
    }

    if ($times[1] < 10) {
        $times[1] = '0' . $times[1];
    }

    if ($times[2] < 10) {
        $times[2] = '0' . $times[2];
    }

    $timeU = $times[0] . ':' . $times[1] . ':' . $times[2];
    return $timeU;
}


function dataUser1099Global($idWorker)
{
    $dataEmpresa = '';
    $dataPersonal = User::where('id', $idWorker)->first();
    $confirm = ConfirmationIndependent::where('user_id', $idWorker)->where('independent_contractor', 1)->first();
    if (isset($confirm) && !empty($confirm) && $confirm->personalEmpresa == 2) {
        $dataEmpresa = Companies::where('user_id', $idWorker)->first();
        $dataEmpresa->user_id = User::where('id', $idWorker)->first();
    }

    if (isset($dataEmpresa) && !empty($dataEmpresa)) {
        return $dataEmpresa;
    } else {
        return $dataPersonal;
    }
}

function dataPayUnitsServicesForWorker($worker_id = null, $fecha_desde = null, $fecha_hasta = null, $paid = 1, $isForHome = false, $isXml = false, $idNote = null)
{

    $filters = [
        'paid' => $paid,
        'desde' => $fecha_desde,
        'hasta' => $fecha_hasta,
        'worker_id' => $worker_id
    ];


    $registerAttentions = [];
    if ($isForHome) {
        $registerAttentions = RegisterAttentions::where('start', '>=', new \DateTime($fecha_desde))
            ->where('end', '<=', new \DateTime($fecha_hasta))->get();
    } elseif (isset($idNote) && $isXml) {
        $registerAttentions = [RegisterAttentions::find(intval($idNote))];
    } else {
        $registerAttentions = RegisterAttentions::where('worker_id', $filters['worker_id'])
            ->where('start', '>=', new \DateTime($fecha_desde))
            ->where('end', '<=', new \DateTime($fecha_hasta))->get();
    }

    $dataCompare = DB::select('SELECT id FROM register_attentions WHERE paid = 1 OR collected = 1');
    $arrayForCompare = [];
    if (isset($dataCompare) && !empty($dataCompare) && count($dataCompare) >= 1) {
        foreach ($dataCompare as $key => $dataComp) {
            array_push($arrayForCompare, $dataComp->id);
        }
    }

    $registerAttentionss = [];
    if ((isset($registerAttentions) && !empty($registerAttentions) && count($registerAttentions) >= 1) && (isset($arrayForCompare) && !empty($arrayForCompare) && count($arrayForCompare) >= 1)) {
        if (!$isXml) {
            foreach (collect($registerAttentions)->whereIn('id', $arrayForCompare) as $registerAttention) {

                $timeAttention = $registerAttention->start->diff($registerAttention->end);
                $times = explode(":", $timeAttention->format('%H:%i:%s'));

                if ($times[0] < 10) {
                    $times[0] = str_split($times[0])[1];
                }

                if ($times[1] < 10) {
                    $times[1] = '0' . $times[1];
                }

                if ($times[2] < 10) {
                    $times[2] = '0' . $times[2];
                }

                $registerAttention->time_attention = $times[0] . ':' . $times[1] . ':' . $times[2];

                array_push($registerAttentionss, $registerAttention);
            }
        } else {
            $registerAttentions;
            $registerAttention = $registerAttentions[0];
            $timeAttention = $registerAttention->start->diff($registerAttention->end);
            $times = explode(":", $timeAttention->format('%H:%i:%s'));

            if ($times[0] < 10) {
                $times[0] = str_split($times[0])[1];
            }

            if ($times[1] < 10) {
                $times[1] = '0' . $times[1];
            }

            if ($times[2] < 10) {
                $times[2] = '0' . $times[2];
            }

            $registerAttention->time_attention = $times[0] . ':' . $times[1] . ':' . $times[2];

            array_push($registerAttentionss, $registerAttention);
        }

        $arrayCollect = collect($registerAttentionss)->unique();
        $arraySum = [];
        if (count($arrayCollect) > 1) {
            foreach ($arrayCollect as $keyI => $registerAttention) {
                $count = $arrayCollect
                    ->where('worker_id', $registerAttention->worker_id)
                    ->where('patiente_id', $registerAttention->patiente_id)
                    ->where('service_id', $registerAttention->service_id)
                    ->where('sub_service_id', $registerAttention->sub_service_id);

                if (count($count) > 1) {
                    if (isset($count) && !empty($count) && count($count) >= 1) {
                        foreach ($count->where('id', '<>', $registerAttention->id) as $key => $registerAttent) {
                            $registerAttention->time_attention = sumaFechasTiempos($registerAttention->time_attention, $registerAttent->time_attention);
                            array_push($arraySum, $registerAttention);
                            unset($arrayCollect[$key]);
                        }
                    }
                } elseif (count($count) == 1) {
                    foreach ($arrayCollect->where('id', $registerAttention->id) as $key => $registerAttent) {
                        //$registerAttention->time_attention = sumaFechasTiempos($registerAttention->time_attention, $registerAttent->time_attention);
                        array_push($arraySum, $registerAttention);
                        unset($arrayCollect[$key]);
                    }
                }
            }
        } else {
            $arraySum = $registerAttentionss;
        }

        $arraySumClean = collect($arraySum)->unique()->filter();

        $arrayFinal = [];
        $sumaPagos = 0;
        $sumaCobros = 0;
        $gananciaEmpresa = 0;
        $arrayXml = '';
        if (isset($arraySumClean) && !empty($arraySumClean) && count($arraySumClean) >= 1) {
            foreach ($arraySumClean as $arraySumC) {
                $arraySumC->note = NotesSubServicesRegister::find($arraySumC->id);
                $dataWorker = User::where('id', $arraySumC->worker_id)->first();
                $dataindependentContractor = ConfirmationIndependent::where('user_id', $arraySumC->worker_id)->first();
                $arraySumC->worker_id = $dataWorker;

                if (isset($dataindependentContractor) && !empty($dataindependentContractor)) {
                    $arraySumC->independent_contractor = $dataindependentContractor;
                }

                $firstName = '';
                if (isset(json_decode($dataWorker)->first_name) && !empty(json_decode($dataWorker)->first_name)) {
                    $firstName = json_decode($dataWorker)->first_name;
                } elseif (isset($dataWorker['first_name']) && !empty($dataWorker['first_name'])) {
                    $firstName = $dataWorker['first_name'];
                } elseif (isset($dataWorker->first_name) && !empty($dataWorker->first_name)) {
                    $firstName = $dataWorker->first_name;
                }

                $lastName = '';
                if (isset(json_decode($dataWorker)->last_name) && !empty(json_decode($dataWorker)->last_name)) {
                    $lastName = json_decode($dataWorker)->last_name;
                } elseif (isset($dataWorker['last_name']) && !empty($dataWorker['last_name'])) {
                    $lastName = $dataWorker['last_name'];
                } elseif (isset($dataWorker->last_name) && !empty($dataWorker->last_name)) {
                    $lastName = $dataWorker->last_name;
                }
                $arraySumC->worker_full_name = $firstName . ' ' .  $lastName;

                $dataPatiente = User::find($arraySumC->patiente_id);
                $arraySumC->patiente_id = $dataPatiente;

                $arraySumC->patiente_full_name = json_decode($dataPatiente)->first_name . ' ' .  json_decode($dataPatiente)->last_name;

                $dataService = Service::find($arraySumC->service_id);
                $arraySumC->service_id = $dataService;
                $arraySumC->name_service = json_decode($dataService)->name_service;

                $dataSubService = SubServices::find($arraySumC->sub_service_id);
                $arraySumC->sub_service_id = $dataSubService;
                $arraySumC->name_sub_service = json_decode($dataSubService)->name_sub_service;

                $arraySumC->service_and_sub_service = $arraySumC->name_service . ' - ' . $arraySumC->name_sub_service;
                $idWorker = '';
                if (isset($dataWorker['id']) && !empty($dataWorker['id'])) {
                    $idWorker = $dataWorker['id'];
                } elseif (isset($dataWorker->id) && !empty($dataWorker->id)) {
                    $idWorker = $dataWorker->id;
                }

                $dataPagosWorker = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $idWorker)->first();

                if (isset($dataPagosWorker) && !empty($dataPagosWorker)) {
                    if (!isset($dataPagosWorker->salary) || empty($dataPagosWorker->salary)) {
                        $dataPagosWorker->salary = $dataSubService->worker_payment;
                        $arraySumC->unit_value_worker = $dataPagosWorker->salary;
                        $arraySumC->workerIdIc = $dataPagosWorker->workerIdIc;
                    } else {
                        $arraySumC->unit_value_worker = $dataPagosWorker->salary;
                        $arraySumC->workerIdIc = $dataPagosWorker->workerIdIc;
                    }

                    $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataPagosWorker->id)->first();

                    if (isset($dataConfig) && !empty($dataConfig)) {
                        if (isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)) {
                            $dataUnidadConfig = Units::find($dataConfig->unit_id);
                            if (isset($dataUnidadConfig) && !empty($dataUnidadConfig)) {
                                $arraySumC->unidad_time_worker = $dataUnidadConfig->time;
                                $arraySumC->unidad_type_worker = $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_worker_int = $dataUnidadConfig->type_unidad;
                            }
                        } else {
                            $dataUnidadWorker = Units::find($dataSubService->unit_worker_payment_id);
                            $arraySumC->unidad_time_worker = $dataUnidadWorker->time;
                            $arraySumC->unidad_type_worker = $dataUnidadWorker->type_unidad == 0 ? 'Minutes' : 'Hours';
                            $arraySumC->unidad_type_worker_int = $dataUnidadWorker->type_unidad;
                        }
                    } else {
                        $dataUnidadWorker = Units::find($dataSubService->unit_worker_payment_id);
                        $arraySumC->unidad_time_worker = $dataUnidadWorker->time;
                        $arraySumC->unidad_type_worker = $dataUnidadWorker->type_unidad == 0 ? 'Minutes' : 'Hours';
                        $arraySumC->unidad_type_worker_int = $dataUnidadWorker->type_unidad;
                    }


                    $unidadesPorPagar = '';
                    $times = explode(":", $arraySumC->time_attention);
                    if ($arraySumC->unidad_type_worker_int == 0) {
                        $unidH = ($times[0] * 60) / $arraySumC->unidad_time_worker;
                        $unidM = $times[1] / $arraySumC->unidad_time_worker;

                        $calc = $unidH + $unidM;
                        $unidadesPorPagar = number_format((float)$calc, 2, '.', '');
                    } else {
                        $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_worker;
                        $unidadesPorPagar = number_format((float)$calc, 2, '.', '');
                    }

                    //dd($dataWorker->id, $dataPatiente->id, $dataService->id, $dataSubService->id, data_previa_month_day_first(), data_previa_month_day_last());
                    $crediMemos = ReasonMemoForPai::where('service_id', $dataService->id)
                        ->where('worker_id', $dataWorker->id)
                        ->where('sub_service_id', $dataSubService->id)
                        ->where('patiente_id', $dataPatiente->id)
                        ->where('from', '>=', new \DateTime($fecha_desde))
                        ->where('to', '<=', new \DateTime($fecha_hasta))->first();

                    if(isset($crediMemos)){
                        $arraySumC->credi_memos = $crediMemos;
                        $arraySumC->montMemos = 0;
                        if(count(json_decode($crediMemos->monts_memo)) > 1){
                            foreach(json_decode($crediMemos->monts_memo) as $k => $v){
                                foreach(json_decode($crediMemos->monts_memo) as $k2 => $v2){
                                    if($k < $k2){
                                        $arraySumC->montMemos = number_format((float)$v, 2, '.', '') + number_format((float)$v2, 2, '.', '');
                                    }
                                }
                            }
                        }else{
                            $arraySumC->montMemos = number_format((float)json_decode($crediMemos->monts_memo)[0], 2, '.', '');
                        }
                    }else{
                        $arraySumC->credi_memos = [];
                        $arraySumC->montMemos = number_format((float)$arraySumC->montMemos, 2, '.', '');
                    }

                    $arraySumC->unid_pay_worker = $unidadesPorPagar;
                    $calcPay = $arraySumC->unid_pay_worker * $dataPagosWorker->salary;
                    $arraySumC->mont_pay = number_format((float)$calcPay, 2, '.', '');
                }

                if ($isForHome || $isXml) {
                    $dataCobroPatiente = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $dataPatiente->id)->first();

                    if (isset($dataCobroPatiente) && !empty($dataCobroPatiente)) {
                        //if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                        if (!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)) {
                            $dataCobroPatiente->customer_payment = $dataSubService->price_sub_service;
                            $arraySumC->unit_value_patiente = $dataSubService->price_sub_service;
                        } else {
                            $arraySumC->unit_value_patiente = $dataCobroPatiente->customer_payment;
                        }

                        $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataCobroPatiente->id)->first();
                        if (isset($dataConfig) && !empty($dataConfig)) {
                            if (isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)) {
                                $dataUnidadConfig = Units::find($dataConfig->unit_id);
                                if (isset($dataUnidadConfig) && !empty($dataUnidadConfig)) {
                                    $arraySumC->unidad_time_patiente = $dataUnidadConfig->time;
                                    $arraySumC->unidad_type_patiente =  $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                    $dataCobroPatiente->unidades_aprovadas = $dataUnidadConfig->approved_units;
                                    $arraySumC->unidad_type_patiente_int = $dataUnidadConfig->type_unidad;
                                }
                            } else {
                                $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                            }
                            $arraySumC->code_patiente = $dataConfig->code_patiente ?? '';
                        } else {
                            $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                            $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                            $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                            $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                            $arraySumC->code_patiente = '';
                        }
                        //}

                        $unidadesPorCobrar = '';
                        $times = explode(":", $arraySumC->time_attention);
                        if ($arraySumC->unidad_type_patiente_int == 0) {
                            if ($arraySumC->unidad_time_patiente != 0) {
                                $unidH = ($times[0] * 60) / $arraySumC->unidad_time_patiente;
                            }
                            if ($arraySumC->unidad_time_patiente != 0) {
                                $unidM = $times[1] / $arraySumC->unidad_time_patiente;
                            }

                            $calc = $unidH + $unidM;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        } else {
                            $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_patiente;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        }

                        $arraySumC->unid_cob_patiente = $unidadesPorCobrar;
                        $calcCob = $arraySumC->unid_cob_patiente * $dataCobroPatiente->customer_payment;
                        $arraySumC->mont_cob = number_format((float)$calcCob, 2, '.', '');
                    }

                    $calcGan = $arraySumC->mont_cob - $arraySumC->mont_pay;
                    $arraySumC->ganancia_empresa = number_format((float)$calcGan, 2, '.', '');

                    $sumaCobros = $sumaCobros + $arraySumC->mont_cob;
                    $gananciaEmpresa = $gananciaEmpresa + $arraySumC->ganancia_empresa;
                }

                if ($isXml) {
                    $textStatus = 'In Progress';
                    $valNote = '';
                    if ((isset($arraySumC->note->note) && isset($arraySumC->note->firma)) || (!empty($arraySumC->note->note) && !empty($arraySumC->note->firma))) {
                        $valNote = $arraySumC->note->note;
                    };

                    $arrayXml = [
                        'submiterID' => json_decode($arraySumC->service_id)->num_prov . '_HUNIT',
                        'caseno' => $arraySumC->code_patiente,
                        'firstname' => json_decode($arraySumC->patiente_id)->first_name,
                        'lastname' => json_decode($arraySumC->patiente_id)->last_name,
                        'activitydatetime' => [
                            'startdate' => date_format($arraySumC->start, "Y/m/d"),
                            'starttime' => date_format($arraySumC->start, "H:i:s"),
                            'enddate' => date_format($arraySumC->end, "Y/m/d"),
                            'endtime' => date_format($arraySumC->end, "H:i:s"),
                        ],
                        'authoritation' => '',
                        'authserviceid' => '',
                        'workerid' => $arraySumC->workerIdIc,
                        'location' => '',
                        'primarydiagnosis' => '',
                        'status' => $textStatus,
                        'program' => json_decode($arraySumC->service_id)->num_prov,
                        'vendorserviceid' => '',
                        'totalcost' => $arraySumC->mont_cob,
                        'units' => $arraySumC->mont_pay,
                        'placeofservice' => '',
                        'groupnote' => $valNote,
                        'contacttype' => [
                            'value' => 'Progress Note'
                        ]
                    ];

                    $titleFileForZip = json_decode($arraySumC->worker_id)->first_name . '_' . json_decode($arraySumC->worker_id)->last_name . '_' . $arraySumC->name_sub_service;
                }

                $sumaPagos = $sumaPagos + $arraySumC->mont_pay;

                array_push($arrayFinal, $arraySumC);
            }
        }

        if ($isForHome) {
            return [
                'montoCobroTotal' => isset($sumaCobros) && !empty($sumaCobros) ? number_format((float)$sumaCobros, 2, '.', '') : '0.00',
                'montoPagoTotal' => isset($sumaPagos) && !empty($sumaPagos) ? number_format((float)$sumaPagos, 2, '.', '') : '0:00',
                'montoGananciaTotal' => isset($gananciaEmpresa) && !empty($gananciaEmpresa) ? number_format((float)$gananciaEmpresa, 2, '.', '') : '0.00'
            ];
        } elseif ($isXml) {
            return ['arrayXml' => $arrayXml, 'titleFileForZip' => str_replace(' ', '_', $titleFileForZip)];
        } else {
            return [
                'dataPagos' => collect($arrayFinal)->unique(),
                'montoPagoTotal' => isset($sumaPagos) && !empty($sumaPagos) ? number_format((float)$sumaPagos, 2, '.', '') : '0:00'
            ];
        }
    } else {
        if ($isForHome) {
            return [
                'montoCobroTotal' => '0.00',
                'montoPagoTotal' => '0:00',
                'montoGananciaTotal' => '0.00'
            ];
        } elseif ($isXml) {
            return ['arrayXml' => [], 'titleFileForZip' => ''];
        } else {
            return [
                'dataPagos' => [],
                'montoPagoTotal' => '0:00'
            ];
        }
    }
}

function generar1099($filters)
{
    if (ob_get_length() > 0) {
        ob_end_clean();
        ob_start();
        ob_end_flush();
    } else {
        ob_start();
        ob_end_flush();
    }

    $dataWorker = dataUser1099Global(intval($filters['worker_id']));

    $dataPagos = dataPayUnitsServicesForWorker($filters['worker_id'], $filters['fecha_desde'], $filters['fecha_hasta'], 1);
    $updateDataDoc = GenerateDocuments1099::find($filters['document_1099_id']);

    $updateDataDoc->eftor_check = $filters['eftor_check'];
    if (isset($filters['invoice_number']) && !empty($filters['invoice_number'])) {
        $updateDataDoc->invoice_number = $filters['invoice_number'];
    } elseif (empty($filters['invoice_number'])) {
        $updateDataDoc->invoice_number = NULL;
    }

    $updateDataDoc->save();

    $namePdf = documentsEditors::find(11);

    $nameFile = '';
    $fullNameArrayCompani = '';
    $fullNameArray = '';
    $addresArray = '';
    $confirm = ConfirmationIndependent::where('user_id', intval($filters['worker_id']))->where('independent_contractor', 1)->first();
    if (isset($confirm) && !empty($confirm)) {
        if ($confirm->independent_contractor == 1) {
            $buscar = array(".", ",", ";", ":");
            $remplazar = array("", "", "", "");

            $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $dataWorker->name));

            if ($confirm->personalEmpresa == 2) {
                $fullNameArrayCompani = $dataWorker->name;
                $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $fullNameArrayCompani));
                $fullNameArray = json_decode($dataWorker->user_id)->first_name . ' ' . json_decode($dataWorker->user_id)->last_name;
                $addresArray = $dataWorker->street_addres;
            } else {
                $fullNameArrayCompani = $dataWorker->first_name . ' ' . $dataWorker->last_name;
                $fullNameArray = $dataWorker->first_name . ' ' . $dataWorker->last_name;
                $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $fullNameArrayCompani));
                $addresArray = $dataWorker->street_addres;
            }
        } else {
            $buscar = array(".", ",", ";", ":");
            $remplazar = array("", "", "", "");

            $fullNameArrayCompani = $dataWorker->first_name . ' ' . $dataWorker->last_name;
            $fullNameArray = $dataWorker->first_name . ' ' . $dataWorker->last_name;
            $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $fullNameArrayCompani));
            $addresArray = $dataWorker->street_addres;
        }
    }

    $vendorCodeArray = $dataWorker->id;

    $arrayData = [
        'infoUser' => $dataWorker,
        'vendorCode' => $vendorCodeArray,
        'fullName' => $fullNameArray,
        'fullNameCompani' => $fullNameArrayCompani,
        'vendorCode' => $vendorCodeArray,
        'addres' => $addresArray,
        'eftorCheck' =>  $filters['eftor_check'],
        'invoiceNumber' => isset($filters['invoice_number']) && !empty($filters['invoice_number']) ? $filters['invoice_number'] : '',
        'desde' => date_format(date_create($filters['fecha_desde']), 'm/d/Y'),
        'hasta' => date_format(date_create($filters['fecha_hasta']), 'm/d/Y'),
        'datePai' => date("m/d/Y", strtotime(date_format(date_create($filters['fecha_hasta']), 'm/d/Y') . "+ 1 days")),
        'dataPagos' => isset($dataPagos['dataPagos']) && !empty($dataPagos['dataPagos']) ? $dataPagos['dataPagos'] : [],
        'montoTotal' => isset($dataPagos['montoPagoTotal']) && !empty($dataPagos['montoPagoTotal']) && isset($dataPagos['montoPagoTotal']) && !empty($dataPagos['montoPagoTotal']) ? $dataPagos['montoPagoTotal'] : 00.00,
    ];

    //foreach($dataPagos['dataPagos'] as $key => $value) {
    //dd($value->id);
    //}

    //dd($arrayData['montoTotal'], $arrayData['montoTotal']);

    $filename = str_replace(' ', '_', $namePdf->name_document_editor) . "_" . str_replace(' ', '_', $nameFile) . '_' . date("d_m_Y") . '.pdf';
    $title = str_replace(' ', '_', $namePdf->name_document_editor) . "_" . str_replace(' ', '_', $nameFile) . '_' . date("d_m_Y");
    $titleFileOrFile = 'templatesDocuments.' . str_replace(' ', '_', $namePdf->name_document_editor);

    if (isset($namePdf->backgroundImg) && !empty($namePdf->backgroundImg)) {
        Config::set('tcpdf.image_background', public_path($namePdf->backgroundImg));
    } else {
        Config::set('tcpdf.use_original_header', false);
    }

    if (isset($namePdf->paginate) && !empty($namePdf->paginate) && ($namePdf->paginate == 1 || $namePdf->paginate == true)) {
        Config::set('tcpdf.use_original_footer', true);
    }


    // dd(collect($arrayData));
    $view = View::make($titleFileOrFile, collect($arrayData));
    $html = $view->render();

    $pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // dd(Config::get('tcpdf.use_original_header'), Config::get('tcpdf.image_background'), $pdf);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(PDF_AUTHOR);
    $pdf->SetTitle(!empty($title) ? $title : PDF_HEADER_TITLE);
    $pdf->SetSubject($nameFile . '.');
    $pdf->SetKeywords('TCPDF, PDF');

    // set margins
    $pdf->SetMargins(15, 15,  15);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


    $pdf->AddPage();

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output(storage_path('app/templates_documents') . '/' . $filename, 'F');

    $updateDataDocT = GenerateDocuments1099::find($filters['document_1099_id']);

    $updateDataDocT->file = $filename;

    $updateDataDocT->save();

    return ['worker_id' => $filters['worker_id'], 'file' => asset('templatesDocuments/' . $filename)];
}


/** Actual month first day **/
function data_first_month_day()
{
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year)) . ' 00:00:01';
}

/** Actual month last day **/
function data_last_month_day()
{
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

    return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year)) . ' 23:59:59';
};

/** Last month first day **/
function data_first_month_day_last()
{
    $month = date('m') - 1;
    $year = date('Y');
    return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year)) . ' 00:00:01';
}

/** Last month last day **/
function data_last_month_day_last()
{
    $month = date('m') - 1;
    $year = date('Y');
    $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

    return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year)) . ' 23:59:59';
};

/** Tree month first day **/
function data_first_month_day_tri()
{
    $month = date('m') - 3;
    $year = date('Y');
    return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year)) . ' 00:00:01';
}

function data_previa_month_day_first()
{
    $month = date('m');
    $year = date('Y');
    $day = date('d');

    if ($day <= 15) {
        $monthL = date('m') - 1;
        return date('Y-m-d', mktime(0, 0, 0, $monthL, 16, $year)) . ' 00:00:01';
    } else {
        return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year)) . ' 00:00:01';
    }
}

function data_previa_month_day_last()
{
    $month = date('m');
    $year = date('Y');
    $day = date('d');

    if ($day >= 16) {
        return date('Y-m-d', mktime(0, 0, 0, $month, 15, $year)) . ' 23:59:59';
    } else {
        $monthL = date('m') - 1;
        $dayL = date("d", mktime(0, 0, 0, $monthL + 1, 0, $year));
        return date('Y-m-d', mktime(0, 0, 0, $monthL, $dayL, $year)) . ' 23:59:59';
    }
}

function dataPagCobGanActual()
{
    return dataPayUnitsServicesForWorker(null, data_first_month_day(), data_last_month_day(), '1', true);
}

function dataPagCobGanLast()
{
    return dataPayUnitsServicesForWorker(null, data_first_month_day_last(), data_last_month_day_last(), '1', true);
}

function dataPagCobGanTri()
{
    return dataPayUnitsServicesForWorker(null, data_first_month_day_Tri(), data_last_month_day_last(), '1', true);
}

function sendXml($idNote, $dateForFile = null)
{
    $dataConsulta = dataPayUnitsServicesForWorker(null, null, null, 1, false, true, $idNote);
    $dataForXml = $dataConsulta['arrayXml']; //return ['arrayXml' => $arrayXml, 'titleFileForZip' => $titleFileForZip];
    $titleFileForZip = $dataConsulta['titleFileForZip'] . '_' . $dateForFile;

    // Esperar 1 segundo
    usleep(1000000);
    $nameFile = $dataForXml['submiterID'] . '_' . (new DateTime())->format("dmY_hisA") . '.xml';

    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;

    $activitiesimport = $dom->createElement("activitiesimport");
    $activitiesimport = $dom->appendChild($activitiesimport);
    $activitiesimport->setAttribute('submitterID', $dataForXml['submiterID']);

    $consumers = $dom->createElement("consumers");
    $consumers = $activitiesimport->appendChild($consumers);

    $caseno = $dom->createElement("caseno");
    $caseno = $consumers->appendChild($caseno);
    $caseno->setAttribute('caseno', $dataForXml['caseno']);

    $firstname = $dom->createElement("firstname");
    $firstname = $caseno->appendChild($firstname);
    $textfirstname = $dom->createTextNode($dataForXml['firstname']);
    $textfirstname = $firstname->appendChild($textfirstname);

    $lastname = $dom->createElement("lastname");
    $lastname = $caseno->appendChild($lastname);
    $textlastname = $dom->createTextNode($dataForXml['lastname']);
    $textlastname = $lastname->appendChild($textlastname);

    $activity = $dom->createElement("activity");
    $activity = $caseno->appendChild($activity);

    foreach ($dataForXml as $key => $value) {
        if ($key == 'activitydatetime') {
            $activitydatetime = $dom->createElement($key);
            $activitydatetime = $activity->appendChild($activitydatetime);

            foreach ($value as $k => $v) {
                $titlek = $dom->createElement($k);
                $titlek = $activitydatetime->appendChild($titlek);
                $textK = $dom->createTextNode($v);
                $textK = $titlek->appendChild($textK);
            }
        }
    }

    foreach ($dataForXml as $key => $value) {
        if (
            $key == 'authoritation' ||
            $key == 'authserviceid' ||
            $key == 'workerid' ||
            $key == 'location' ||
            $key == 'primarydiagnosis' ||
            $key == 'status' ||
            $key == 'program' ||
            $key == 'vendorserviceid' ||
            $key == 'totalcost' ||
            $key == 'units' ||
            $key == 'placeofservice' ||
            $key == 'groupnote'
        ) {
            $titlekey = $dom->createElement($key);
            $titlekey = $caseno->appendChild($titlekey);
            $textKey = $dom->createTextNode($value);
            $textKey = $titlekey->appendChild($textKey);
        }
    }

    foreach ($dataForXml as $key => $value) {
        if ($key == 'contacttype') {
            $contacttype = $dom->createElement($key);
            $contacttype = $caseno->appendChild($contacttype);

            foreach ($value as $k => $v) {
                $titlek = $dom->createElement($k);
                $titlek = $contacttype->appendChild($titlek);
                $textK = $dom->createTextNode($v);
                $textK = $titlek->appendChild($textK);
            }
        }
    }

    $micarpeta = storage_path('app/files_xml/') . $titleFileForZip . '/';
    if (!file_exists($micarpeta)) {
        mkdir($micarpeta, 0755, true);
    }

    $dom->save($micarpeta . $nameFile);

    return true;
}

function generateZipXmls(Request $request)
{
    $filters = $request->all();
    $filtersDate = [];
    unset($filters['_token']);
    foreach (array('desde' => 'start', 'hasta' => 'end') as $k => $v) {
        $filtersDate[$v] = $filters[$k];
        unset($filters[$k]);
    }
    $filters['paid'] = 1;

    $notes = RegisterAttentions::where($filters)->where('start', '>=', $filtersDate['start'])->where('end', '<=', $filtersDate['end'])->get();

    $nameDirZip = str_replace(' ', '_', User::where('id', $filters['worker_id'])->first()->first_name . '_' .
        User::where('id', $filters['worker_id'])->first()->last_name . '_' .
        str_replace(' ', '_', SubServices::where('id', $filters['sub_service_id'])->first()->name_sub_service) . '_from_' .
        date_format(date_create($filtersDate['start']), 'd_m_Y') . '_to_' .
        date_format(date_create($filtersDate['end']), 'd_m_Y'));

    $fileFinal = storage_path('app/files_xml') . '/' . $nameDirZip . ".zip";

    if (is_file($fileFinal)) {
        unlink($fileFinal);
    }

    //dd($fileFinal);
    // Creamos un instancia de la clase ZipArchive
    $zip = new ZipArchive();
    // Creamos y abrimos un archivo zip temporal
    $zip->open($fileFinal, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    //indicamos cual es la carpeta que se quiere comprimir
    $origen = storage_path('app/files_xml') . '/' . $nameDirZip;

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($origen), RecursiveIteratorIterator::LEAVES_ONLY);

    //Ahora recorremos el arreglo con los nombres los archivos y carpetas y se adjuntan en el zip
    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($origen) + 1);

            $zip->addFile($filePath, $relativePath);
        }
    }



    // Añadimos un directorio
    //$zip->addEmptyDir($nameDirZip . '_files_xml');
    //Añadimos los archivos
    //foreach($notes as $k => $n){
    //$nameFile = User::where('id', $filters['patiente_id'])->first()->first_name . '_' . User::where('id', $filters['patiente_id'])->first()->last_name . '_' . $n->id . '.xml';
    // Añadimos un archivo en la raid del zip.
    //$zip->addFile($nameFile, $nameFile);
    //Añadimos un archivo dentro del directorio que hemos creado
    //$zip->addFile(storage_path('app/files_xml') . '/' . $nameFile, $nameDirZip . '_files_xml/' . basename($nameFile));
    //}
    // Una vez añadido los archivos deseados cerramos el zip.
    $zip->close();

    if (is_file($fileFinal)) {
        return $nameDirZip . ".zip";
    }
}

function deleteDirectory($dir)
{
    if (!$dh = @opendir($dir)) return;
    while (false !== ($current = readdir($dh))) {
        if ($current != '.' && $current != '..') {
            if (!@unlink($dir . '/' . $current))
                deleteDirectory($dir . '/' . $current);
        }
    }
    closedir($dh);
    @rmdir($dir);
}

function workersSinNotas($desde = null, $hasta = null){
    $filtersAssigned = [];

    //busco la relacion entre pacientes y trabajadores (los trabajadores asignados de cada patiente)
    $workersAssigneds = PatientesAssignedWorkers::all();
    foreach($workersAssigneds as $key => $val){
        //los filtro solo para obtener el id de patiente y el id del trabajador
        array_push($filtersAssigned, ['worker_id' => $val['worker_id'], 'patiente_id' => $val['patiente_id']]);
    }

    $arrayWorkersSinNotas = [];
    //corro un ciclo para ver las notas de cada relacion obtenida anteriormente
    foreach($filtersAssigned as $key => $val){
        //si no paso fechas en los filtros uso las del sistema (quincena anterior)
        $dateDesde = isset($desde) ? $desde : data_previa_month_day_first();
        $dateHasta = isset($hasta) ? $hasta : data_previa_month_day_last();

        $notasCreadas = RegisterAttentions::where($val)->where('start', '>=', $dateDesde)->where('end', '<=', $dateHasta)->get();
        //si el resultado del filtro es 0 egrego esa data de worker y patiente a los datos q pasare a la vista ubicando su nombre y apellido;
        if(count($notasCreadas) == 0){
            if(count($notasCreadas) == 0){
                $workerFil = User::where('id', $val['worker_id'])->first();
                $patienteFil = User::where('id', $val['patiente_id'])->first();
                if(($workerFil && $workerFil->statu_id == 1) && ($patienteFil && $patienteFil->statu_id == 1)){
                    $val['worker_id'] = $workerFil ? $workerFil->first_name . ' ' . $workerFil->last_name : $val['worker_id'];
                    $val['patiente_id'] = $patienteFil ? $patienteFil->first_name . ' ' . $patienteFil->last_name : $val['patiente_id'];
                    array_push($arrayWorkersSinNotas, $val);
                }
            }
        }
    }
    //retorno los datos de trabajadores q estan asignados a un paciente y q no tienen notas en la quincena anterior o en la quincena de fechas ingresadas
    return count(collect($arrayWorkersSinNotas)) >= 1 ? collect($arrayWorkersSinNotas) : collect([]);
}