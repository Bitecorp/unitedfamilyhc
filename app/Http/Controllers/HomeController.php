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
        $documentsExpireds = AlertDocumentsExpired::all();

        $workersCount = User::where('role_id', '<>', 1)->where('role_id', '<>', 4)->where('role_id', '<>', 5)->where('statu_id', 1)->get() ?? [];
        $patientesCount = User::where('role_id', 4)->where('statu_id', 1)->get() ?? [];

        $workersDocumentsExpireds = [];
        if (isset($documentsExpireds) && !empty($documentsExpireds) && count($documentsExpireds) > 0) {
            foreach ($documentsExpireds as $key => $documentsExpired) {
                $dataDocument = DocumentUserFiles::where('id', $documentsExpired->document_user_file_id)->first() ?? '';
                if (isset($dataDocument) && !empty($dataDocument)) {
                    $infoUser = User::where('id', $dataDocument->user_id)->where('role_id', 2)->where('role_id', 3)->first() ?? '';
                    if (isset($infoUser) && !empty($infoUser)) {
                        array_push($workersDocumentsExpireds, $infoUser);
                    }
                }
            }
        }

        $patientesDocumentsExpireds = [];
        if (isset($documentsExpireds) && !empty($documentsExpireds) && count($documentsExpireds) > 0) {
            foreach ($documentsExpireds as $key => $documentsExpired) {
                $dataDocument = DocumentUserFiles::where('id', $documentsExpired->document_user_file_id)->first() ?? '';
                if (isset($dataDocument) && !empty($dataDocument)) {
                    $infoUser = User::where('id', $dataDocument->user_id)->where('role_id', 4)->first() ?? '';
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

        $subServicesActives = RegisterAttentions::where('worker_id', Auth::user()->id)->where('status', 1)->get() ?? [];
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

        //dd(collect($dataPatientes));

        //foreach(collect($dataSearch) as $key => $dataS){
            //dd($dataS);
        //}

        if (Auth::user()->role_id != 2) {
            return view('pages/dashboard/dashboard-v1')
                ->with('workersCount', count($workersCount))
                ->with('countDocumentsWorkers', count(collect($workersDocumentsExpireds)))
                ->with('patientesCount', count($patientesCount))
                ->with('countDocumentsPatientes', count(collect($patientesDocumentsExpireds)));
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
        $dataPatiente = User::where('id', $input['patiente_id'])->first() ?? '';

        $subservices = [];
        if (isset($servicesAssignedss) && !empty($servicesAssignedss) && count($servicesAssignedss) >= 1) {
            foreach ($servicesAssignedss as $servicesAssignedsss) {
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
}