<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubServicesRequest;
use App\Http\Requests\UpdateSubServicesRequest;
use App\Repositories\SubServicesRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ConfigSubServicesPatienteRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Service;
use App\Models\SubServices;
use App\Models\SalaryServiceAssigneds;
use App\Models\Units;
use App\Models\Patiente;
use App\Models\ConfigSubServicesPatiente;

class SubServicesController extends AppBaseController
{
    /** @var  SubServicesRepository */
    private $subServicesRepository;

    /** @var ConfigSubServicesPatienteRepository $configSubServicesPatienteRepository*/
    private $configSubServicesPatienteRepository;

    public function __construct(SubServicesRepository $subServicesRepo, ConfigSubServicesPatienteRepository $configSubServicesPatienteRepo)
    {
        $this->subServicesRepository = $subServicesRepo;
        $this->configSubServicesPatienteRepository = $configSubServicesPatienteRepo;
    }

    /**
     * Display a listing of the SubServices.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $subServices = $this->subServicesRepository->all();

        return view('sub_services.index')
            ->with('subServices', $subServices);
    }

    public function list($idService, Request $request)
    {
        $service = Service::where('id', $idService)->first();
        $subServices = SubServices::where('service_id', $idService)->get();
        return view('sub_services.index')
            ->with('subServices', $subServices)
            ->with('service', $service);
    }

    /**
     * Show the form for creating a new SubServices.
     *
     * @return Response
     */
    public function create()
    {
        return view('sub_services.create');
    }

    public function addSubService($idService, Request $request)
    {
        $units = Units::all();
        $service = Service::where('id', $idService)->first();
        return view('sub_services.create')
            ->with('service', $service)
            ->with('units', $units);
    }

    /**
     * Store a newly created SubServices in storage.
     *
     * @param CreateSubServicesRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if(isset($data['type_salary'])){
            $data['type_salary'] = true;
        }else{
            $data['type_salary'] = false;
        }

        $subServices = $this->subServicesRepository->create($data);

        Flash::success('Sub Services saved successfully.');

        return redirect(route('subServices.list', [$data['service_id']]));
    }

    public function assignSubService($userId, $subServiceId, Request $request){
        $data = $request->all();
        $subService = SubServices::where('id', $subServiceId)->first();

        $exist = SalaryServiceAssigneds::where('service_id', $subServiceId)->where('user_id', $userId)->first();

        $dataUser = Patiente::where('id', $userId)->first();

        if(!empty($exist)){
            $config = ConfigSubServicesPatiente::where('salary_service_assigned_id', $exist->id)->first();
            if(isset($config) && !empty($config)){
                $configSubServicesPatiente = $this->configSubServicesPatienteRepository->delete($config->id);
            }

            $flight = SalaryServiceAssigneds::find($exist->id);
            $flight->delete();
        }else{
            $saveData = new SalaryServiceAssigneds;
            $saveData->user_id = $userId;
            $saveData->service_id = $subServiceId;
            $saveData->type_salary = $subService->type_salary;
            $saveData->customer_payment = $subService->price_sub_service;
            $saveData->salary = $subService->worker_payment;
            $saveData->created_at = now();
            $saveData->updated_at = now();
            $saveData->save();

            $input['salary_service_assigned_id'] = $saveData->id;

            $configSubServicesPatiente = $this->configSubServicesPatienteRepository->create($input);

        }

        if($dataUser->role_id == 4){
            return redirect(route('patientes.show', [$userId]). '?services');
        }else{
            return redirect(route('workers.show', [$userId]). '?services');
        }
    }

    /**
     * Display the specified SubServices.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subServices = $this->subServicesRepository->find($id);

        if (empty($subServices)) {
            Flash::error('Sub Services not found');

            return redirect(route('subServices.index'));
        }

        return view('sub_services.show')->with('subServices', $subServices);
    }

    /**
     * Show the form for editing the specified SubServices.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subServices = $this->subServicesRepository->find($id);
        $service = Service::where('id', $subServices->service_id)->first();
        $units = Units::all();

        if (empty($subServices)) {
            Flash::error('Sub Services not found');

            return redirect(route('subServices.index'));
        }

        return view('sub_services.edit')->with('subServices', $subServices)->with('service', $service)->with('units', $units);
    }

    /**
     * Update the specified SubServices in storage.
     *
     * @param int $id
     * @param UpdateSubServicesRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $subServices = $this->subServicesRepository->find($id);

        if (empty($subServices)) {
            Flash::error('Sub Services not found');

            return redirect(route('subServices.index'));
        }

        if(isset($data['type_salary'])){
            $data['type_salary'] = true;
        }else{
            $data['type_salary'] = false;
        }

        if($data['type_salary'] == false){
            $data['unit_worker_payment_id'] = NULL;
            $data['unit_customer_id'] = NULL;
        }

        $subServices = $this->subServicesRepository->update($data, $id);

        Flash::success('Sub Services updated successfully.');

        return redirect(route('subServices.list', [$subServices->service_id]));
    }

    /**
     * Remove the specified SubServices from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subServices = $this->subServicesRepository->find($id);

        if (empty($subServices)) {
            Flash::error('Sub Services not found');

            return redirect(route('subServices.index'));
        }

        $exist = SalaryServiceAssigneds::where('service_id', $subServices->id)->get();

        if(isset($exist) && !empty($exist) && count($exist) >= 1){
            Flash::error('There are salaries with this sub-service assigned to it, it cannot be eliminated.');

            return redirect(route('subServices.list', [$subServices->service_id]));
        }

        $this->subServicesRepository->delete($id);

        Flash::success('Sub Services deleted successfully.');

        return redirect(route('subServices.list', [$subServices->service_id]));
    }
}
