<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertDocumentsExpired;
use App\Models\Worker;

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
        return view('pages/dashboard/dashboard-v1')->with('countDocumentsWorkers', count($documentsExpired))->with('workersCount', count($workersCount))->with('patientesCount', count($patientesCount));
    }
}
