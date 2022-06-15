<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertDocumentsExpired;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use App\Models\SalaryServiceAssigneds;
use App\Models\SubServices;
use App\Models\Service;
use App\Models\ServiceAssigneds;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentsExpired = AlertDocumentsExpired::all();
        $workersCount = Worker::where('role_id', '<>', [1,4])->where('statu_id', 1)->get();
        $patientesCount = Worker::where('role_id', 4)->where('statu_id', 1)->get();

        $salaryServicesAssigneds = SalaryServiceAssigneds::where('user_id', Auth::user()->id)->get();

        $services = [];
        $subServices = [];

        if(!empty($salaryServicesAssigneds) && isset($salaryServicesAssigneds) && count($salaryServicesAssigneds) >= 1){
            foreach($salaryServicesAssigneds AS $salaryServiceAssigned){
                $subService = SubServices::find($salaryServiceAssigned->service_id);
                if(!empty($subService) && isset($subService)){
                    array_push($subServices, $subService);
                }
            }
        }

        $servicesAssigneds = ServiceAssigneds::where('user_id', Auth::user()->id)->get();
        if(!empty($servicesAssigneds) && isset($servicesAssigneds) && count($servicesAssigneds) >= 1){
            $services = Service::where('services', json_decode($servicesAssigneds->services))->get();
        }

        if(Auth::user()->role_id != 2){
            return view('pages/dashboard/dashboard-v1')->with('countDocumentsWorkers', count($documentsExpired))->with('workersCount', count($workersCount))->with('patientesCount', count($patientesCount));
        }else{
            return view('pages/dashboard/clearView')->with('services', $services)->with('subServices', $subServices);
        }
    }
}
