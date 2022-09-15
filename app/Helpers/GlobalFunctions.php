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

use App\Models\documentsEditors;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\View;

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
                $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
    $confirm = ConfirmationIndependent::where('user_id', $idWorker)->where('independent_contractor', 1)->first();
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

function dataPayUnitsServicesForWorker($worker_id, $fecha_desde, $fecha_hasta, $paid){
        $filters = [
            'paid' => $paid,
            'desde' => $fecha_desde,
            'hasta' => $fecha_hasta,
            'worker_id' => $worker_id
        ];

        $registerAttentions = RegisterAttentions::where('worker_id', $filters['worker_id'])
                ->where('start', '>=', $filters['desde'])
                ->where('end', '<=', $filters['hasta'])->where('paid', '<=', 1)->get();

            
        
        $registerAttentionss = [];
        $sumaPagos = 0;
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
                    $arraySumC->worker_full_name = json_decode($dataWorker)->first_name . ' ' .  json_decode($dataWorker)->last_name;

                    $dataindependentContractor = ConfirmationIndependent::where('user_id', json_decode($arraySumC->worker_id)->id)->first();
                    if(isset($dataindependentContractor) && !empty($dataindependentContractor)){
                        $arraySumC->independent_contractor = $dataindependentContractor;
                    }

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

                    $sumaPagos = $sumaPagos + $arraySumC->mont_pay;
                    array_push($arrayFinal, $arraySumC);
                }
            }
            //dd($sumaPagos);
            return [
                'dataPagos' => collect($arrayFinal)->unique(), 
                'montoPagoTotal' => $sumaPagos
            ];
        }
}

function generar1099($filters){
        if(ob_get_length() > 0){
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
        if(isset($filters['invoice_number']) && !empty($filters['invoice_number'])){
            $updateDataDoc->invoice_number = $filters['invoice_number'];
        }

        $updateDataDoc->save();

        $namePdf = documentsEditors::find(11);

        $nameFile = '';
        $fullNameArrayCompani = '';
        $fullNameArray = '';
        $addresArray = '';
        $confirm = ConfirmationIndependent::where('user_id', intval($filters['worker_id']))->where('independent_contractor', 1)->first();
        if(isset($confirm) && !empty($confirm)){
            if ($confirm->independent_contractor == 1) {
                $buscar = array (".",",",";",":");    
                $remplazar = array ("","","","");

                $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $dataWorker->name));

                if($confirm->personalEmpresa == 2){
                    $fullNameArrayCompani = $dataWorker->name;
                    $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $fullNameArrayCompani));
                    $fullNameArray = json_decode($dataWorker->user_id)->first_name . ' ' . json_decode($dataWorker->user_id)->last_name;
                    $addresArray = $dataWorker->street_addres;                   
                }else{
                    $fullNameArrayCompani = $dataWorker->first_name . ' ' .$dataWorker->last_name;
                    $fullNameArray = $dataWorker->first_name . ' ' .$dataWorker->last_name;
                    $nameFile = str_replace($buscar, $remplazar, str_replace(" ", "_", $fullNameArrayCompani));
                    $addresArray = $dataWorker->street_addres;                   
                }

                
            } else {
                $buscar = array (".",",",";",":");    
                $remplazar = array ("","","","");

                $fullNameArrayCompani = $dataWorker->first_name . ' ' .$dataWorker->last_name;
                $fullNameArray = $dataWorker->first_name . ' ' .$dataWorker->last_name;
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
            'datePai' => date("m/d/Y",strtotime(date_format(date_create($filters['fecha_hasta']), 'm/d/Y')."+ 1 days")),
            'dataPagos' => isset($dataPagos['dataPagos']) && !empty($dataPagos['dataPagos']) ? $dataPagos['dataPagos'] : [],
            'montoTotal' => isset($dataPagos['montoPagoTotal']) && !empty($dataPagos['montoPagoTotal']) && isset($dataPagos['montoPagoTotal'][0]) && !empty($dataPagos['montoPagoTotal'][0]) ? $dataPagos['montoPagoTotal'][0] : (isset($dataPagos['montoPagoTotal']) && !empty($dataPagos['montoPagoTotal']) && !isset($dataPagos['montoPagoTotal'][0]) || empty($dataPagos['montoPagoTotal'][0]) ? $dataPagos['montoPagoTotal'] : 00.00),
        ];

        //foreach($dataPagos['dataPagos'] as $key => $value) {
            //dd($value->id);
        //}

        //dd($arrayData['montoTotal']);

        $filename = str_replace(' ', '_', $namePdf->name_document_editor) . "_" . str_replace(' ', '_', $nameFile) . '_' . date("d_m_Y") . '.pdf';
        $title = str_replace(' ', '_', $namePdf->name_document_editor) . "_" . str_replace(' ', '_', $nameFile) . '_' . date("d_m_Y");
        $titleFileOrFile = 'templatesDocuments.' . str_replace(' ', '_', $namePdf->name_document_editor);

        if(isset($namePdf->backgroundImg) && !empty($namePdf->backgroundImg)){
            Config::set('tcpdf.image_background', public_path($namePdf->backgroundImg));
        }else{
            Config::set('tcpdf.use_original_header', false);
        }

        if(isset($namePdf->paginate) && !empty($namePdf->paginate) && ($namePdf->paginate == 1 || $namePdf->paginate == true)){
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

        return ['worker_id' =>$filters['worker_id'], 'file' => asset('templatesDocuments/' . $filename)];
}


/** Actual month first day **/
function data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year)) . ' 00:00:01';
}

/** Actual month last day **/
function data_last_month_day() { 
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
    return date('Y-m-d', mktime(0,0,0, $month, $day, $year)) . ' 23:59:59';
};

function data_previa_month_day_first() {
    $month = date('m');
    $year = date('Y');
    $day = date('d');

    if($day <= 15){
        return date('Y-m-d', mktime(0,0,0, $month-1, 16, $year)) . ' 00:00:01';
    }else{
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year)) . ' 00:00:01';
    }
    
}

function data_previa_month_day_last() {
    $month = date('m');
    $year = date('Y');
    $day = date('d');

    if($day >= 16){
        return date('Y-m-d', mktime(0,0,0, $month, 15, $year)) . ' 23:59:59';
    }else{    
        $monthL = date('m')-1;
        $dayL = date("d", mktime(0,0,0, $monthL+1, 0, $year));
        return date('Y-m-d', mktime(0,0,0, $monthL, $dayL, $year)) . ' 23:59:59';
    }
    
}