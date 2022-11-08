<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertDocumentsExpired;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\SalaryServiceAssigneds;
use App\Models\SubServices;
use App\Models\Service;
use App\Models\ServiceAssigneds;
use App\Models\PatientesAssignedWorkers;
use App\Models\DocumentUserFiles;
use Illuminate\Support\Collection;
use App\Models\RegisterAttentions;
use DB;
use Carbon\Carbon;
use App\Models\NotesSubServicesRegister;
use App\Models\ReferencesPersonalesTwo;
use Flash;
use DateTime;
use App\Models\Units;
use App\Models\ConfigSubServicesPatiente;
use App\Models\GenerateDocuments1099;
use App\Models\ConfirmationIndependent;
use App\Models\documentsEditors;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class jsonUsuario {
    public $servicio = "";
    public $statusPay = "";
    public $startDate = "";
    public $endDate = "";
    public $dataW = "";
    public $dataP = "";
}

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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *confirmationIndependent
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayUsers = [];
        $usersActives = DB::table('users')
            ->where('statu_id', 1)
            ->join('document_user_files', 'users.id', '=', 'document_user_files.user_id')
            ->select('document_user_files.id')
            ->get();
        foreach($usersActives->unique() as $usersActive){
            array_push($arrayUsers, $usersActive->id);
        }

        $documentsExpireds = AlertDocumentsExpired::all();

        $workersCount = User::whereNotIn('role_id', [1, 4, 5])->where('statu_id', 1)->get();
        $patientesCount = User::where('role_id', 4)->where('statu_id', 1)->get();
        $workersDocumentsExpireds = [];
        if (isset($documentsExpireds) && !empty($documentsExpireds) && count($documentsExpireds) > 0) {
            foreach ($documentsExpireds->whereNotIn('user_id', $arrayUsers) as $key => $documentsExpired) {
                $dataDocument = DocumentUserFiles::where('id', $documentsExpired->document_user_file_id)->first();
                if (isset($dataDocument) && !empty($dataDocument)) {
                    $infoUser = User::where('id', $dataDocument->user_id)->first();
                    if (isset($infoUser) && !empty($infoUser) && ($infoUser['role_id'] == 2 || $infoUser['role_id'] == 3)) {
                        array_push($workersDocumentsExpireds, $infoUser);
                    }
                }
            }
        }

        $patientesDocumentsExpireds = [];
        if (isset($documentsExpireds) && !empty($documentsExpireds) && count($documentsExpireds) > 0) {
            foreach ($documentsExpireds->whereNotIn('user_id', $arrayUsers) as $key => $documentsExpired) {
                $dataDocument = DocumentUserFiles::where('id', $documentsExpired->document_user_file_id)->first();
                if (isset($dataDocument) && !empty($dataDocument)) {
                    $infoUser = User::where('id', $dataDocument->user_id)->where('role_id', 4)->first();
                    if (isset($infoUser) && !empty($infoUser)) {
                        array_push($patientesDocumentsExpireds, $infoUser);
                    }
                }
            }
        }

        $salaryServicesAssigneds = SalaryServiceAssigneds::where('user_id', Auth::user()->id)->get();

        $services = [];
        $subServices = [];

        if (!empty($salaryServicesAssigneds) && isset($salaryServicesAssigneds) && count($salaryServicesAssigneds) >= 1) {
            foreach ($salaryServicesAssigneds as $salaryServiceAssigned) {
                $subService = SubServices::find($salaryServiceAssigned->service_id);
                if (!empty($subService) && isset($subService)) {
                    array_push($subServices, $subService);
                }
            }
        }

        $servicesAssigneds = ServiceAssigneds::where('user_id', Auth::user()->id)->first();

        if (!empty($servicesAssigneds) && isset($servicesAssigneds)) {
            foreach (json_decode($servicesAssigneds->services) as $key => $arrayServicesID) {
                $infoService = Service::where('id', intval($arrayServicesID))->first();
                if (!empty($infoService) && isset($infoService)) {
                    array_push($services, $infoService);
                }
            }
        }

        $subServicesActives = RegisterAttentions::where('worker_id', Auth::user()->id)->where('status', 1)->get();
        $dataSearch = [];
        $subservices = [];
        $dataPatientes = [];
        $servicesAssignedss = [];
        if (!empty($subServicesActives) && isset($subServicesActives) && count($subServicesActives) >= 1) {
            foreach ($subServicesActives as $key => $val) {
                $dataServiceSelect = Service::find($val->service_id);
                $dataUserSelect = User::find($val->patiente_id);
                $dataSubServiceSelect = SubServices::find($val->sub_service_id);
                array_push($dataSearch, 
                    array(
                        'patiente_id' => $val->patiente_id,
                        'service_id' => $val->service_id,
                        'sub_service_id' => $val->sub_service_id,
                        'patiente' => array('id' => $val->patiente_id, 'fullNamePatiente' => $dataUserSelect->first_name . ' ' . $dataUserSelect->last_name),
                        'service' => array('id' => $val->service_id, 'name_service' => $dataServiceSelect->name_service),
                        'sub_service' => array('id' => $val->sub_service_id, 'name_sub_service' => $dataSubServiceSelect->name_sub_service),
                        'status' => $val->status
                    )
                );
                array_push($dataPatientes, User::where('id', $val->patiente_id)->first());
            }

            if (!empty($dataSearch) && isset($dataSearch) && count($dataSearch) >= 1) {
                foreach ($dataSearch as $dataS) {
                    array_push($servicesAssignedss, SalaryServiceAssigneds::where('user_id', $dataS['patiente_id'])->get());
                }
            }

            if (isset($servicesAssignedss) && !empty($servicesAssignedss) && count($servicesAssignedss) >= 1) {
                foreach ($dataSearch as $dataS) {
                    foreach ($servicesAssignedss as $servicesAssignedsss) {
                        foreach ($servicesAssignedsss as $servicesAss) {
                            $itemExist = RegisterAttentions::where('worker_id', Auth::user()->id)->where('service_id', $dataS['service_id'])->where('patiente_id', $dataS['patiente_id'])->where('sub_service_id', $servicesAss->service_id)->where('status', 1)->first();
                            if (!empty($itemExist)) {
                                $service = SubServices::where('id', $servicesAss->service_id)->first();
                                if (isset($service) && !empty($service)) {
                                    array_push($subservices, $service);
                                }
                            }
                        }
                    }
                }
            }
        }

        //dd($dataPagCobGan);

        if (Auth::user()->role_id == 1) {
            return view('pages/dashboard/dashboard-v1')
                ->with('workersCount', count($workersCount))
                ->with('countDocumentsWorkers', count(collect($workersDocumentsExpireds)))
                ->with('patientesCount', count($patientesCount))
                ->with('countDocumentsPatientes', count(collect($patientesDocumentsExpireds)))
                ->with('dataPagCobGanActual', dataPagCobGanActual())
                ->with('dataPagCobGanLast', dataPagCobGanLast())
                ->with('dataPagCobGanTri', dataPagCobGanTri());
        } else {
            $dataFull = ReferencesPersonalesTwo::where('user_id', Auth::user()->id)->where('reference_number', 2)->get();

            if(isset($dataFull) && !empty($dataFull)){
                if(!isset($dataFull[0]->name_job) || empty($dataFull[0]->name_job) && !isset($dataFull[0]->address) || empty($dataFull[0]->address) && !isset($dataFull[0]->phone) || empty($dataFull[0]->phone) && !isset($dataFull[0]->ocupation) || empty($dataFull[0]->ocupation) && !isset($dataFull[0]->time) || empty($dataFull[0]->time)){
                    return redirect(route('workers.edit', Auth::user()->id));
                }
            }

            return view('pages/dashboard/clearView')
                ->with('services', isset($services) && !empty($services) ? collect($services) : [])
                ->with('dataSearch', isset($dataSearch) && !empty($dataSearch) ? collect($dataSearch) : []);
        }
    }

    public function searchPatienteService(Request $request)
    {
        $input = $request->all();

        $usersServices = [];
        $allDataServicesAssingeds = ServiceAssigneds::all();

        if (!empty($allDataServicesAssingeds) && isset($allDataServicesAssingeds) && count($allDataServicesAssingeds) >= 1) {
            foreach ($allDataServicesAssingeds as $allDataServicesAssinged) {
                foreach (json_decode($allDataServicesAssinged->services) as $val) {
                    if (intval($val) == intval($input['service_id'])) {
                        array_push($usersServices, $allDataServicesAssinged->user_id);
                    }
                }
            }
        }

        $workersAss = PatientesAssignedWorkers::where('worker_id', Auth::user()->id)->get();

        $userForSelect = [];
        if (!empty($workersAss) && isset($workersAss) && count($workersAss) >= 1) {
            foreach ($workersAss as $workersAs) {
                if (!empty($usersServices) && isset($usersServices) && count($usersServices) >= 1) {
                    foreach (array_unique($usersServices) as $workersA) {
                        if (intval($workersA) == intval($workersAs->patiente_id)) {
                            $infoUsers = User::where('id', intval($workersA))->get();
                            if (!empty($infoUsers) && isset($infoUsers) && count($infoUsers) >= 1) {
                                array_push($userForSelect, $infoUsers);
                            }
                        }
                    }
                }
            }
        }

        $patientes = [];
        foreach ($userForSelect as $usersss) {
            foreach ($usersss as $userss) {
                array_push($patientes, $userss);
            }
        }

        return response()->json(['patientes' => collect($patientes)]);
    }

    public function searchServicesWorker(Request $request)
    {
        $input = $request->all();
        $services = [];

        $servicesAssigneds = ServiceAssigneds::where('user_id', $input['worker_id'])->first();

        if (!empty($servicesAssigneds) && isset($servicesAssigneds)) {
            foreach (json_decode($servicesAssigneds->services) as $key => $arrayServicesID) {
                $infoService = Service::where('id', intval($arrayServicesID))->first();
                if (!empty($infoService) && isset($infoService)) {
                    array_push($services, $infoService);
                }
            }
        }

        $patientesRelation = PatientesAssignedWorkers::where('worker_id', $input['worker_id'])->get();
        $patientes = [];
        if(isset($patientesRelation) && !empty($patientesRelation) && count($patientesRelation) >= 1){
            foreach($patientesRelation as $patienteRelation){
                $patiente = User::where('id', $patienteRelation->patiente_id)->first();
                if(isset($patiente) && !empty($patiente)){
                    array_push($patientes, $patiente);
                }
            }
        }

        return response()->json(['services' => collect($services), 'patientes' => collect($patientes)]);
    }

    public function searchSubServicesPatiente(Request $request)
    {
        $input = $request->all();

        $workerID = isset($input['worker_id']) && !empty($input['worker_id']) ? $input['worker_id'] : Auth::user()->id;

        $servicesAssignedss = SalaryServiceAssigneds::where('user_id', $input['patiente_id'])->get();
        $servicesAssignedssW = SalaryServiceAssigneds::where('user_id', $workerID)->get();
        $dataPatiente = User::where('id', $input['patiente_id'])->first() ?? '';

        $idsServicesWorkersPatiente = [];
        foreach($servicesAssignedss as $servicesAssignedsW){
            array_push($idsServicesWorkersPatiente, $servicesAssignedsW->service_id);
        }

        $subservices = [];
        if (isset($servicesAssignedss) && !empty($servicesAssignedss) && count($servicesAssignedss) >= 1) {
            foreach ($servicesAssignedssW->whereIn('service_id', $idsServicesWorkersPatiente) as $servicesAssignedsss) {
                $itemExist = RegisterAttentions::where('worker_id', $workerID)->where('service_id', $input['service_id'])->where('patiente_id', $input['patiente_id'])->where('sub_service_id', $servicesAssignedsss->service_id)->where('status', 1)->first();
                if (empty($itemExist)) {
                    $service = SubServices::where('id', $servicesAssignedsss->service_id)->first();
                    if (isset($service) && !empty($service)) {
                        array_push($subservices, $service);
                    }
                }
            }
        }

        return response()->json(['subServices' => collect($subservices), 'dataPatiente' => $dataPatiente]);
    }

    public function registerAttentions(Request $request)
    {
        $input = $request->all();

        $regExs = RegisterAttentions::where('worker_id', $input['worker_id'])->where('patiente_id', $input['patiente_id'])->where('service_id', $input['service_id'])->where('sub_service_id', $input['sub_service_id'])->where('status', 1)->first();
        

        $idReg = '';
        if (isset($regExs) && !empty($regExs)) {
            $regUp = RegisterAttentions::find($regExs->id);

            $regUp->worker_id = $input['worker_id'];
            $regUp->service_id = $input['service_id'];
            $regUp->patiente_id = $input['patiente_id'];
            $regUp->sub_service_id = $input['sub_service_id'];
            $regUp->lat_end = $input['lat'];
            $regUp->long_end = $input['long'];
            $regUp->end = Carbon::now();

            $regUp->status = 2;

            $regUp->save();

            $idReg = $regExs->id;

            $regNote = new NotesSubServicesRegister;

            $regNote->register_attentions_id = $regExs->id;
            $regNote->worker_id = $input['worker_id'];
            $regNote->service_id = $input['service_id'];
            $regNote->patiente_id = $input['patiente_id'];
            $regNote->sub_service_id = $input['sub_service_id'];
            $regNote->note = null;
            $regNote->firma = null;
 
            $regNote->save();

        } else {
            $regAt = new RegisterAttentions;

            $regAt->worker_id = $input['worker_id'];
            $regAt->service_id = $input['service_id'];
            $regAt->patiente_id = $input['patiente_id'];
            $regAt->sub_service_id = $input['sub_service_id'];
            $regAt->lat_start = $input['lat'];
            $regAt->long_start = $input['long'];
            $regAt->start = Carbon::now();
            $regAt->status = 1;

            $regAt->save();

            $idReg = $regAt->id;
        }

        $reg = RegisterAttentions::find($idReg);

        if(isset($idReg) && !empty($idReg)){
            $note = NotesSubServicesRegister::where('register_attentions_id', $idReg)->first();
        }

        $subServicesActive = RegisterAttentions::where('worker_id', Auth::user()->id)->where('status', 1)->get();

        $subServicesActives = false;

        if (!empty($subServicesActive) && isset($subServicesActive) && count($subServicesActive) >= 1) {
            $subServicesActives = true;
        } else {
            $subServicesActives = false;
        }

        return response()->json([
            'data' => $reg, 
            'subServicesActives' => $subServicesActives, 
            'note' => isset($note) && !empty($note) ? $note : null
        ]);        
    }

    public function createMultiRegister(Request $request)
    {
        $input = $request->all();

        for($i = 1; $i <= intval($input['number_of_notes']); $i++){
            $regAt = new RegisterAttentions;

                $regAt->worker_id = $input['worker_id'];
                $regAt->service_id = $input['service_id'];
                $regAt->patiente_id = $input['patiente_id'];
                $regAt->sub_service_id = $input['sub_service_id'];
                $regAt->lat_start = $input['lat_start'];
                $regAt->long_start = $input['long_start'];
                $regAt->start = $input['start'];
                $regAt->lat_end = $input['lat_end'];
                $regAt->long_end = $input['long_end'];
                $regAt->end = $input['end'];
                $regAt->status = 2;

            $regAt->save();

            $regNote = new NotesSubServicesRegister;

                $regNote->register_attentions_id = $regAt->id;
                $regNote->worker_id = $input['worker_id'];
                $regNote->service_id = $input['service_id'];
                $regNote->patiente_id = $input['patiente_id'];
                $regNote->sub_service_id = $input['sub_service_id'];
                $regNote->note = null;
                $regNote->firma = null;
        
            $regNote->save();
        }
        
        return response()->json([
                'msj' => true
        ]);
    }

    public function matchAndControlFilter (Request $request)
    {
        $services = Service::all();
        $dataMensual = $this->matchAndControl() ?? [];
        $dataMensualDasboard = $this->matchAndControlAgrupado($request) ?? [];
        return view('match_and_control.index')->with('services', $services)->with('dataMensual', $dataMensual)->with('dataMensualDasboard', $dataMensualDasboard);
    
    }

    public function generate1099Filters ()
    {
        $services = Service::all();
        $workers = User::all()->whereIn('role_id', 2);
        return view('match_and_control.index')->with('services', $services)->with('workers', $workers);
    
    }

    public function matchAndControlSearch (Request $request, $dataDasboard = false)
    {
        $filters = $request->all();

        $registerAttentions = [];
        if($filters['service_id'] == 'all'){
                if($filters['paid'] == 'all'){
                    $registerAttentions = RegisterAttentions::where('start', '>=', $filters['desde'])->where('end', '<=', $filters['hasta'])->get();
                }else{
                    $registerAttentions = RegisterAttentions::where('paid', $filters['paid'])->where('start', '>=', $filters['desde'])->where('end', '<=', $filters['hasta'])->get();
                }
        }else{
            if($filters['paid'] == 'all'){
                $registerAttentions = RegisterAttentions::where('service_id', $filters['service_id'])
                    ->where('start', '>=', $filters['desde'])
                    ->where('end', '<=', $filters['hasta'])->get();
            }else{
                $registerAttentions = RegisterAttentions::where('service_id', $filters['service_id'])
                    ->where('paid', $filters['paid'])
                    ->where('start', '>=', $filters['desde'])
                    ->where('end', '<=', $filters['hasta'])->get();
            }
        }

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

            $arrayCollect = collect($registerAttentionss)->unique()->filter();

            $arraySum = [];
            if(count($arrayCollect) >= 1){
                foreach($arrayCollect as $keyI => $registerAttention){
                    $count = $arrayCollect
                        ->where('worker_id', $registerAttention->worker_id)
                        ->where('patiente_id', $registerAttention->patiente_id)
                        ->where('service_id', $registerAttention->service_id)
                        ->where('sub_service_id', $registerAttention->sub_service_id)
                    ;
                    
                    if(count($count) > 1){
                        if(isset($count) && !empty($count) && count($count) > 1){
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
                    $dataindependentContractor = ConfirmationIndependent::where('user_id', $arraySumC->worker_id)->first();
                    $arraySumC->worker_id = $dataWorker;

                    if(isset($dataindependentContractor) && !empty($dataindependentContractor)){
                        $arraySumC->independent_contractor = $dataindependentContractor;
                    }

                    $dataPatiente = User::find($arraySumC->patiente_id);
                    $arraySumC->patiente_id = $dataPatiente;

                    $dataService = Service::find($arraySumC->service_id);
                    $arraySumC->service_id = $dataService;

                    $dataSubService = SubServices::find($arraySumC->sub_service_id);
                    $arraySumC->sub_service_id = $dataSubService;                 

                    $idWorker = '';
                    if(isset($dataWorker['id']) && !empty($dataWorker['id'])){
                        $idWorker = $dataWorker['id'];
                    }elseif(isset($dataWorker->id) && !empty($dataWorker->id)){
                        $idWorker = $dataWorker->id;
                    }

                    $dataPagosWorker = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $idWorker)->first();

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


                    $dataCobroPatiente = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $dataPatiente->id)->first();

                    if(isset($dataCobroPatiente) && !empty($dataCobroPatiente)){
                        //if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                            if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                                $dataCobroPatiente->customer_payment = $dataSubService->price_sub_service;
                                $arraySumC->unit_value_patiente = $dataSubService->price_sub_service;
                            }else{
                                $arraySumC->unit_value_patiente = $dataCobroPatiente->customer_payment;
                            }
                            
                            $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataCobroPatiente->id)->first();
                            if(isset($dataConfig) && !empty($dataConfig)){
                                if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                                    $dataUnidadConfig = Units::find($dataConfig->unit_id);
                                    if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                                        $arraySumC->unidad_time_patiente = $dataUnidadConfig->time;
                                        $arraySumC->unidad_type_patiente =  $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                        $dataCobroPatiente->unidades_aprovadas = $dataUnidadConfig->approved_units;
                                        $arraySumC->unidad_type_patiente_int = $dataUnidadConfig->type_unidad;
                                    }
                                }else{
                                    $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                    $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                    $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                    $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                                }
                            }else{
                                $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                            }
                        //}

                        $unidadesPorCobrar = '';
                        $times = explode(":", $arraySumC->time_attention);
                        if($arraySumC->unidad_type_patiente_int == 0){
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidH = ($times[0] * 60) / $arraySumC->unidad_time_patiente;
                            }
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidM = $times[1] / $arraySumC->unidad_time_patiente;
                            }

                            $calc = $unidH + $unidM;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');

                        }else{
                            $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_patiente;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        }
                        
                        $arraySumC->unid_cob_patiente = $unidadesPorCobrar;
                        $calcCob = $arraySumC->unid_cob_patiente * $dataCobroPatiente->customer_payment;
                        $arraySumC->mont_cob = number_format((float)$calcCob, 2, '.', '');
                    }

                    $calcGan = $arraySumC->mont_cob - $arraySumC->mont_pay;
                    $arraySumC->ganancia_empresa = number_format((float)$calcGan, 2, '.', '');

                    array_push($arrayFinal, $arraySumC);
                }
            }            

            $dataPatiente = $this->matchAndControlSearchPatientes($request);

            if($dataDasboard){
                return [
                    'dataW' => collect($arrayFinal),
                    'dataP' => $dataPatiente,
                    'msj' => "data encontrada",
                    'success' => true
                ];
            }else{
                return response()->json([
                    'dataW' => collect($arrayFinal),
                    'dataP' => $dataPatiente,
                    'msj' => "data encontrada",
                    'success' => true
                ]); 
            }

        }else{
            $dataPatiente = $this->matchAndControlSearchPatientes($request);

            if($dataDasboard){
                return [
                    'dataW' => [],
                    'dataP' => $dataPatiente,
                    'msj' => "data no encontrada",
                    'success' => true
                ];
            }else{
                return response()->json([
                    'dataW' => [],
                    'dataP' => $dataPatiente,
                    'msj' => "data no encontrada",
                    'success' => true
                ]);
            } 
        }
    }

    public function matchAndControlAgrupado (Request $request)
    {   
        $data = [];
        if(count($request->all()) == 0){
            $data = $this->matchAndControl(true);
        }else{
            $data = $this->matchAndControlSearch($request, true);
        }

        $newDataW = [];
        $dataW2 = $data['dataW'];
        foreach($data['dataW'] as $k => $v){
            foreach($dataW2->where('id', '<>', $v['id']) as $k2 => $v2){
                if(json_decode($v['worker_id'])->id == json_decode($v2['worker_id'])->id){
                    $times = explode(":", $v['time_attention']);

                    if(isset($times[0]) && !empty($times[0])){
                        if($times[0] < 10)
                        $times[0] = str_split($times[0])[1] ?? $times[0];
                    }else{
                        $times[0] = '0';
                    }

                    if(isset($times[1]) && !empty($times[1])){
                        if($times[1] < 10)
                        $times[1] = '0' . $times[1];
                    }else{
                        $times[1] = '0';
                    }

                    if(isset($times[2]) && !empty($times[2])){
                        if($times[2] < 10)
                        $times[2] = '0' . $times[2];
                    }else{
                        $times[2] = '0';
                    }


                    $times2 = explode(":", $v2['time_attention']);

                    if(isset($times2[0]) && !empty($times2[0])){
                        if($times2[0] < 10)
                        $times2[0] = str_split($times2[0])[1] ?? $times2[0];
                    }else{
                        $times2[0] = '0';
                    }

                    if(isset($times2[1]) && !empty($times2[1])){
                        if($times2[1] < 10)
                        $times2[1] = '0' . $times2[1];
                    }else{
                        $times2[1] = '0';
                    }

                    if(isset($times2[2]) && !empty($times2[2])){
                        if($times2[2] < 10)
                        $times2[2] = '0' . $times2[2];
                    }else{
                        $times2[2] = '0';
                    }

                    $hor = intval($times[0] + $times2[0]) < 10 ? '0' . strval($times[0] + $times2[0]) : strval($times[0] + $times2[0]);
                    $min = intval($times[1] + $times2[1]) < 10 ? '0' . strval($times[1] + $times2[1]) : strval($times[1] + $times2[1]);
                    $seg = intval($times[2] + $times2[2]) < 10 ? '0' . strval($times[2] + $times2[2]) : strval($times[2] + $times2[2]);

                    if(intval($seg) > 60){
                        $min = intval($min) + explode(".", floatval(intval($seg) / 60))[0];
                        if(intval($min) < 10){
                            $min = strval('0' . strval($min));
                        }

                        if(intval($seg) < 10){
                            $seg = strval('0' . explode(".", floatval(intval($seg) / 60))[1] ?? '0');
                        }
                    }
                    
                    if(intval($min) > 60){
                        $hor = intval($hor) + explode(".", floatval(intval($min) / 60))[0];
                        if(intval($hor) < 10){
                            $hor = strval('0' . strval($hor));
                        }

                        if(intval($min) < 10){
                            $min = strval('0' . explode(".", floatval(intval($min) / 60))[1] ?? '0');
                        }
                    }
                    
                    $v['time_attention'] = $hor . ':' . $min;
                    $v['mont_pay'] = number_format((float)floatval($v['mont_pay'] + $v2['mont_pay']), 2, '.', '');
                    $v['mont_cob'] = number_format((float)floatval($v['mont_cob'] + $v2['mont_cob']), 2, '.', '');
                    $v['ganancia_empresa'] = number_format((float)floatval($v['ganancia_empresa'] + $v2['ganancia_empresa']), 2, '.', '');
                    array_push($newDataW, $v);
                }else{
                    $times = explode(":", $v['time_attention']);
                    $v['time_attention'] = strval($times[0]) . ':' . strval($times[1]);
                    array_push($newDataW, $v);
                }
            }
        }

        $newDataP = [];
        $dataP2 = $data['dataP'];
        foreach($data['dataP'] as $k => $v){
            foreach($dataW2->where('id', '<>', $v['id']) as $k2 => $v2){
                if(json_decode($v['patiente_id'])->id == json_decode($v2['patiente_id'])->id){
                    $times = explode(":", $v['time_attention']);

                    if(isset($times[0]) && !empty($times[0])){
                        if($times[0] < 10)
                        $times[0] = str_split($times[0])[1] ?? $times[0];
                    }else{
                        $times[0] = '0';
                    }

                    if(isset($times[1]) && !empty($times[1])){
                        if($times[1] < 10)
                        $times[1] = '0' . $times[1];
                    }else{
                        $times[1] = '0';
                    }

                    if(isset($times[2]) && !empty($times[2])){
                        if($times[2] < 10)
                        $times[2] = '0' . $times[2];
                    }else{
                        $times[2] = '0';
                    }


                    $times2 = explode(":", $v2['time_attention']);

                    if(isset($times2[0]) && !empty($times2[0])){
                        if($times2[0] < 10)
                        $times2[0] = str_split($times2[0])[1] ?? $times2[0];
                    }else{
                        $times2[0] = '0';
                    }

                    if(isset($times2[1]) && !empty($times2[1])){
                        if($times2[1] < 10)
                        $times2[1] = '0' . $times2[1];
                    }else{
                        $times2[1] = '0';
                    }

                    if(isset($times2[2]) && !empty($times2[2])){
                        if($times2[2] < 10)
                        $times2[2] = '0' . $times2[2];
                    }else{
                        $times2[2] = '0';
                    }

                    $hor = intval($times[0] + $times2[0]) < 10 ? '0' . strval($times[0] + $times2[0]) : strval($times[0] + $times2[0]);
                    $min = intval($times[1] + $times2[1]) < 10 ? '0' . strval($times[1] + $times2[1]) : strval($times[1] + $times2[1]);
                    $seg = intval($times[2] + $times2[2]) < 10 ? '0' . strval($times[2] + $times2[2]) : strval($times[2] + $times2[2]);

                    if(intval($seg) > 60){
                        $min = intval($min) + explode(".", floatval(intval($seg) / 60))[0];
                        if(intval($min) < 10){
                            $min = strval('0' . strval($min));
                        }

                        if(intval($seg) < 10){
                            $seg = strval('0' . explode(".", floatval(intval($seg) / 60))[1] ?? '0');
                        }
                    }
                    
                    if(intval($min) > 60){
                        $hor = intval($hor) + explode(".", floatval(intval($min) / 60))[0];
                        if(intval($hor) < 10){
                            $hor = strval('0' . strval($hor));
                        }

                        if(intval($min) < 10){
                            $min = strval('0' . explode(".", floatval(intval($min) / 60))[1] ?? '0');
                        }
                    }
                    
                    $v['time_attention'] = $hor . ':' . $min;
                    $v['mont_pay'] = number_format((float)floatval($v['mont_pay'] + $v2['mont_pay']), 2, '.', '');
                    $v['mont_cob'] = number_format((float)floatval($v['mont_cob'] + $v2['mont_cob']), 2, '.', '');
                    $v['ganancia_empresa'] = number_format((float)floatval($v['ganancia_empresa'] + $v2['ganancia_empresa']), 2, '.', '');
                    array_push($newDataP, $v);
                }else{
                    $times = explode(":", $v['time_attention']);
                    $v['time_attention'] = strval($times[0]) . ':' . strval($times[1]);
                    array_push($newDataP, $v);
                }
            }
        }

        if(count($request->all()) == 0){
            return collect([
                'dataW' => array_unique($newDataW),
                'dataP' => array_unique($newDataP),
                'msj' => "data encontrada",
                'success' => true
            ]);
        }else{
            return response()->json([
                'dataW' => $newDataW,
                'dataP' => $newDataP,
                'msj' => "data encontrada",
                'success' => true
            ]);
        }
    }

    public function matchAndControlSearchPatientes ($request)
    {
        $filters = $request->all();

        $registerAttentions = [];
        if($filters['service_id'] == 'all'){
            if($filters['paid'] == 'all'){
                $registerAttentions = RegisterAttentions::where('start', '>=', $filters['desde'])->where('end', '<=', $filters['hasta'])->get();
            }else{
                $registerAttentions = RegisterAttentions::where('paid', $filters['paid'])->where('start', '>=', $filters['desde'])->where('end', '<=', $filters['hasta'])->get();
            }
        }else{
            if($filters['paid'] == 'all'){
                $registerAttentions = RegisterAttentions::where('service_id', $filters['service_id'])
                    ->where('start', '>=', $filters['desde'])
                    ->where('end', '<=', $filters['hasta'])->get();
            }else{
                $registerAttentions = RegisterAttentions::where('service_id', $filters['service_id'])
                    ->where('collected', $filters['paid'])
                    ->where('start', '>=', $filters['desde'])
                    ->where('end', '<=', $filters['hasta'])->get();
            }
        }
        
        
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

            $arrayCollect = collect($registerAttentionss)->unique()->filter();

            $arraySum = [];
            if(count($arrayCollect) >= 1){
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
                            array_push($arraySum, $registerAttention);
                            unset($arrayCollect[$key]);  
                        }
                    }
                }
            }else{
                $arraySum = $registerAttentionss;
            }

            $arraySumClean = collect($arraySum)->unique();

            $arrayFinal = [];
            if(isset($arraySumClean) && !empty($arraySumClean) && count($arraySumClean) >= 1){
                foreach($arraySumClean as $arraySumC){
                    $dataWorker = User::find($arraySumC->worker_id);
                    $dataindependentContractor = ConfirmationIndependent::where('user_id', $arraySumC->worker_id)->first();
                    $arraySumC->worker_id = $dataWorker;

                    if(isset($dataindependentContractor) && !empty($dataindependentContractor)){
                        $arraySumC->independent_contractor = $dataindependentContractor;
                    }

                    $dataPatiente = User::find($arraySumC->patiente_id);
                    $arraySumC->patiente_id = $dataPatiente;

                    $dataService = Service::find($arraySumC->service_id);
                    $arraySumC->service_id = $dataService;

                    $dataSubService = SubServices::find($arraySumC->sub_service_id);
                    $arraySumC->sub_service_id = $dataSubService;

                    $idWorker = '';
                    if(isset($dataWorker['id']) && !empty($dataWorker['id'])){
                        $idWorker = $dataWorker['id'];
                    }elseif(isset($dataWorker->id) && !empty($dataWorker->id)){
                        $idWorker = $dataWorker->id;
                    }

                    $dataPagosWorker = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $idWorker)->first();

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


                    $dataCobroPatiente = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $dataPatiente->id)->first();

                    if(isset($dataCobroPatiente) && !empty($dataCobroPatiente)){
                            if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                                $dataCobroPatiente->customer_payment = $dataSubService->price_sub_service;
                                $arraySumC->unit_value_patiente = $dataSubService->price_sub_service;
                            }else{
                                $arraySumC->unit_value_patiente = $dataCobroPatiente->customer_payment;
                            }
                            
                            $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataCobroPatiente->id)->first();
                            if(isset($dataConfig) && !empty($dataConfig)){
                                if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                                    $dataUnidadConfig = Units::find($dataConfig->unit_id);
                                    if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                                        $arraySumC->unidad_time_patiente = $dataUnidadConfig->time;
                                        $arraySumC->unidad_type_patiente =  $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                        $dataCobroPatiente->unidades_aprovadas = $dataUnidadConfig->approved_units;
                                        $arraySumC->unidad_type_patiente_int = $dataUnidadConfig->type_unidad;
                                    }
                                }else{
                                    $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                    $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                    $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                    $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                                }
                            }else{
                                $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                            }
                        //}

                        $unidadesPorCobrar = '';
                        $times = explode(":", $arraySumC->time_attention);
                        if($arraySumC->unidad_type_patiente_int == 0){
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidH = ($times[0] * 60) / $arraySumC->unidad_time_patiente;
                            }
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidM = $times[1] / $arraySumC->unidad_time_patiente;
                            }

                            $calc = $unidH + $unidM;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');

                        }else{
                            $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_patiente;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        }
                        
                        $arraySumC->unid_cob_patiente = $unidadesPorCobrar;
                        $calcCob = $arraySumC->unid_cob_patiente * $dataCobroPatiente->customer_payment;
                        $arraySumC->mont_cob = number_format((float)$calcCob, 2, '.', '');
                    }

                    $calcGan = $arraySumC->mont_cob - $arraySumC->mont_pay;
                    $arraySumC->ganancia_empresa = number_format((float)$calcGan, 2, '.', '');

                    array_push($arrayFinal, $arraySumC);
                }
            }
            
            return collect($arrayFinal); 

        }else{
            return []; 
        }
    }

    public function cobrar(Request $request)
    {
        $filters = $request->all();
        RegisterAttentions::where('id', $filters['note_id'])->update(['collected' => 1]);

        return response()->json([
            'data' => [],
            'msj' => "data actualizada",
            'success' => true
        ]); 
    }

    public function pagar(Request $request)
    {
        $filters = $request->all();
        RegisterAttentions::where('id', $filters['note_id'])->update(['paid' => 1]);
        $dataReg = RegisterAttentions::find($filters['note_id']);

        $existeGenerate1099 = GenerateDocuments1099::where('worker_id', $dataReg->worker_id)->where('from', '>=', $dataReg->start)->where('to', '<=', $dataReg->end)->first() ?? '';

        if(empty($existeGenerate1099)){
            $generate1099 = new GenerateDocuments1099;
        
                $generate1099->worker_id = $dataReg->worker_id;
                $generate1099->from = $dataReg->start;
                $generate1099->to = $dataReg->end;
                $generate1099->eftor_check = null;
                $generate1099->invoice_number = null;
    
            $generate1099->save();
        }

        return response()->json([
            'data' => [],
            'msj' => "data actualizada",
            'success' => true
        ]); 
    }

    public function revertirCobrar(Request $request)
    {
        $filters = $request->all();
        RegisterAttentions::where('id', $filters['note_id'])->update(['collected' => 0]);
        $dataReg = RegisterAttentions::find($filters['note_id']);

        $nameFile = User::find($dataReg->patiente_id)->first_name . '_' . User::find($dataReg->patiente_id)->last_name . '_' . $filters['note_id'] . '.xml';
        if (file_exists(storage_path('app/files_xml') .'/'. $nameFile)) {
            unlink(storage_path('app/files_xml') .'/'. $nameFile); //elimino el f  
        };        

        return response()->json([
            'data' => [],
            'msj' => "data actualizada",
            'success' => true
        ]); 
    }

    public function revertirPagar(Request $request)
    {
        $filters = $request->all();
        RegisterAttentions::where('id', $filters['note_id'])->update(['paid' => 0]);
        $dataReg = RegisterAttentions::find($filters['note_id']);
        
        $generate1099 = GenerateDocuments1099::where('worker_id', $dataReg->worker_id)->where('from', '>=', $dataReg->start)->where('to', '<=', $dataReg->end)->first();
        if(isset($generate1099) && !empty($generate1099)){
            $generate1099Id = GenerateDocuments1099::find($generate1099->id);
        
            $generate1099Id->delete();
            if(isset($generate1099Id->file) &&  !empty($generate1099Id->file)){
                unlink(storage_path('app/templates_documents') .'/'. $generate1099Id->file); //elimino el f   
            }
        }  

        return response()->json([
            'data' => [],
            'msj' => "data actualizada",
            'success' => true
        ]); 
    }

    public function generateDocumentOfPay(Request $request)
    { 
        $filters = $request->all();
        $documents = generar1099($filters);

        return response()->json([
            'data' => isset($documents) && !empty($documents) ? : [],
            'msj' => "documento generado",
            'success' => true
        ]);
    }

    public function dataConsultGenerate1099 (Request $request)
    {
        $filters = $request->all();

        $registerAttentions = RegisterAttentions::where('worker_id', $filters['worker_id'])->where('paid', $filters['paid'])->where('start', '>=', $filters['desde'])->where('end', '<=', $filters['hasta'])->get();       
        
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

            $arrayCollect = collect($registerAttentionss)->unique()->filter();

            $arraySum = [];
            if(count($arrayCollect) >= 1){
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
            
            
            $dataDocument1099 = GenerateDocuments1099::where('worker_id', $filters['worker_id'])
                ->where('from', '>=', $filters['desde'])
                ->where('to', '<=', $filters['hasta'])->first(); 

            $dataWorker = User::find($filters['worker_id']);
            $dataDocument1099->worker_id = $dataWorker;

            $dataindependentContractor = ConfirmationIndependent::where('user_id', $filters['worker_id'])->first();
            if(isset($dataindependentContractor) && !empty($dataindependentContractor)){
                $dataDocument1099->independent_contractor = $dataindependentContractor;
            }
            if(isset($dataDocument1099->file) && !empty($dataDocument1099->file)){
                $dataDocument1099->file = asset('templatesDocuments/' . $dataDocument1099->file);
            }

            return response()->json([
                'dataW' => collect($arrayFinal),
                'data1099' => array(collect($dataDocument1099)->unique()),
                'msj' => "data encontrada",
                'success' => true
            ]); 

        }else{
            return response()->json([
                'dataW' => [],
                'msj' => "data no encontrada",
                'success' => true
            ]); 
        }
    }

    public function matchAndControl($dataDasboard = false)
    {
        $registerAttentions = RegisterAttentions::where('start', '>=', data_previa_month_day_first())->where('end', '<=', data_previa_month_day_last())->get() ?? [];
        
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

            $arrayCollect = collect($registerAttentionss)->unique()->filter();

            $arraySum = [];
            if(count($arrayCollect) >= 1){
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
                            array_push($arraySum, $registerAttention);
                            unset($arrayCollect[$key]);  
                        }
                    }

                }
            }

            $arraySumClean = collect($arraySum)->unique()->filter();
            
            $arrayFinal = [];
            if(isset($arraySumClean) && !empty($arraySumClean) && count($arraySumClean) >= 1){
                foreach($arraySumClean as $arraySumC){
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


                    $dataCobroPatiente = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $dataPatiente->id)->first();

                    if(isset($dataCobroPatiente) && !empty($dataCobroPatiente)){
                        //if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                            if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                                $dataCobroPatiente->customer_payment = $dataSubService->price_sub_service;
                                $arraySumC->unit_value_patiente = $dataSubService->price_sub_service;
                            }else{
                                $arraySumC->unit_value_patiente = $dataCobroPatiente->customer_payment;
                            }
                            
                            $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataCobroPatiente->id)->first();
                            if(isset($dataConfig) && !empty($dataConfig)){
                                if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                                    $dataUnidadConfig = Units::find($dataConfig->unit_id);
                                    if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                                        $arraySumC->unidad_time_patiente = $dataUnidadConfig->time;
                                        $arraySumC->unidad_type_patiente =  $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                        $dataCobroPatiente->unidades_aprovadas = $dataUnidadConfig->approved_units;
                                        $arraySumC->unidad_type_patiente_int = $dataUnidadConfig->type_unidad;
                                    }
                                }else{
                                    $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                    $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                    $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                    $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                                }
                            }else{
                                $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                            }
                        //}

                        $unidadesPorCobrar = '';
                        $times = explode(":", $arraySumC->time_attention);
                        if($arraySumC->unidad_type_patiente_int == 0){
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidH = ($times[0] * 60) / $arraySumC->unidad_time_patiente;
                            }
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidM = $times[1] / $arraySumC->unidad_time_patiente;
                            }

                            $calc = $unidH + $unidM;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');

                        }else{
                            $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_patiente;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        }
                        
                        $arraySumC->unid_cob_patiente = $unidadesPorCobrar;
                        $calcCob = $arraySumC->unid_cob_patiente * $dataCobroPatiente->customer_payment;
                        $arraySumC->mont_cob = number_format((float)$calcCob, 2, '.', '');
                    }

                    $calcGan = $arraySumC->mont_cob - $arraySumC->mont_pay;
                    $arraySumC->ganancia_empresa = number_format((float)$calcGan, 2, '.', '');

                    array_push($arrayFinal, $arraySumC);
                }
            }            

            $dataPatiente = $this->matchAndControlPatientes();
            
            if($dataDasboard){
                return [
                    'dataW' => collect($arrayFinal),
                    'dataP' => $dataPatiente,
                    'msj' => "data encontrada",
                    'success' => true
                ];
            }else{
                return collect([
                    'dataW' => collect($arrayFinal),
                    'dataP' => $dataPatiente,
                    'msj' => "data encontrada",
                    'success' => true
                ]);
            } 

        }else{
            $dataPatiente = $this->matchAndControlPatientes();

            if($dataDasboard){
                return [
                    'dataW' => [],
                    'dataP' => $dataPatiente,
                    'msj' => "data no encontrada",
                    'success' => true
                ];
            }else{
                return collect([
                    'dataW' => [],
                    'dataP' => $dataPatiente,
                    'msj' => "data no encontrada",
                    'success' => true
                ]); 
            }
        }
    }

    public function matchAndControlPatientes ()
    {
        $registerAttentions = RegisterAttentions::where('start', '>=', data_previa_month_day_first())->where('end', '<=', data_previa_month_day_last())->get() ?? []; 
        
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

            $arrayCollect = collect($registerAttentionss)->unique()->filter();

            $arraySum = [];
            if(count($arrayCollect) >= 1){
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
                            array_push($arraySum, $registerAttention);
                            unset($arrayCollect[$key]);  
                        }
                    }
                }
            }else{
                $arraySum = $registerAttentionss;
            }

            $arraySumClean = collect($arraySum)->unique();

            $arrayFinal = [];
            if(isset($arraySumClean) && !empty($arraySumClean) && count($arraySumClean) >= 1){
                foreach($arraySumClean as $arraySumC){
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


                    $dataCobroPatiente = SalaryServiceAssigneds::where('service_id', $dataSubService->id)->where('user_id', $dataPatiente->id)->first();

                    if(isset($dataCobroPatiente) && !empty($dataCobroPatiente)){
                        //if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                            if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                                $dataCobroPatiente->customer_payment = $dataSubService->price_sub_service;
                                $arraySumC->unit_value_patiente = $dataSubService->price_sub_service;
                            }else{
                                $arraySumC->unit_value_patiente = $dataCobroPatiente->customer_payment;
                            }
                            
                            $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataCobroPatiente->id)->first();
                            if(isset($dataConfig) && !empty($dataConfig)){
                                if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                                    $dataUnidadConfig = Units::find($dataConfig->unit_id);
                                    if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                                        $arraySumC->unidad_time_patiente = $dataUnidadConfig->time;
                                        $arraySumC->unidad_type_patiente =  $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                        $dataCobroPatiente->unidades_aprovadas = $dataUnidadConfig->approved_units;
                                        $arraySumC->unidad_type_patiente_int = $dataUnidadConfig->type_unidad;
                                    }
                                }else{
                                    $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                    $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                    $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                    $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                                }
                            }else{
                                $dataUnidadPatiente = Units::find($dataSubService->unit_customer_id);
                                $arraySumC->unidad_time_patiente = $dataUnidadPatiente->time;
                                $arraySumC->unidad_type_patiente =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $arraySumC->unidad_type_patiente_int = $dataUnidadPatiente->type_unidad;
                            }
                        //}

                        $unidadesPorCobrar = '';
                        $times = explode(":", $arraySumC->time_attention);
                        if($arraySumC->unidad_type_patiente_int == 0){
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidH = ($times[0] * 60) / $arraySumC->unidad_time_patiente;
                            }
                            if($arraySumC->unidad_time_patiente != 0){
                                $unidM = $times[1] / $arraySumC->unidad_time_patiente;
                            }

                            $calc = $unidH + $unidM;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');

                        }else{
                            $calc = ($times[0] + ($times[1] / 100)) / $arraySumC->unidad_time_patiente;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        }
                        
                        $arraySumC->unid_cob_patiente = $unidadesPorCobrar;
                        $calcCob = $arraySumC->unid_cob_patiente * $dataCobroPatiente->customer_payment;
                        $arraySumC->mont_cob = number_format((float)$calcCob, 2, '.', '');
                    }

                    $calcGan = $arraySumC->mont_cob - $arraySumC->mont_pay;
                    $arraySumC->ganancia_empresa = number_format((float)$calcGan, 2, '.', '');

                    array_push($arrayFinal, $arraySumC);
                }
            }
            
            return collect($arrayFinal); 

        }else{
            return []; 
        }
    }

    public function myProfile($id){
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('home'));
        }

        return view('profiles.index')->with('dataUser', $user);
    }

    public function settings($id){
        
    }

    public function postMyProfile(Request $request, $id){
        $input = $request->all();

        $user = User::find($id);

        if(isset($input['avatar']) && !empty($input['avatar'])){
            Flash::error('Your image could not be updated at this time, please try again later');

            return view('profiles.index')->with('dataUser', $user);
            //$user->avatar = $input['avatar'];
        }

        if(isset($input['new_password']) && !empty($input['new_password']) && isset($input['confirm_password']) && !empty($input['confirm_password'])){
            if($input['new_password'] == $input['confirm_password']){
                $user->password = Hash::make($input['new_password']);
            }else{
                Flash::error('Invalid confirmation password');

                return view('profiles.index')->with('dataUser', $user);
            } 
        }else{
        
            Flash::error('Confirm your password');

            return view('profiles.index')->with('dataUser', $user);

        }
        
        $user->save();

        Flash::success('Your password updated successfully');

        return view('profiles.index')->with('dataUser', $user);
        
    }

    public function postSettings(Request $request, $id){
        $input = $request->all();

    }
}