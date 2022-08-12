<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalaryServiceAssignedsRequest;
use App\Http\Requests\UpdateSalaryServiceAssignedsRequest;
use App\Repositories\SalaryServiceAssignedsRepository;
use App\Repositories\ConfigSubServicesPatienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\SalaryServiceAssigneds;
use App\Models\Service;
use App\Models\SubServices;
use App\Models\Patiente;
use App\Models\ConfigSubServicesPatiente;
use App\Models\User;
use App\Models\Units;
use Flash;
use Response;

class SalaryServiceAssignedsController extends AppBaseController
{
    /** @var  SalaryServiceAssignedsRepository */
    private $salaryServiceAssignedsRepository;

    /** @var ConfigSubServicesPatienteRepository $configSubServicesPatienteRepository*/
    private $configSubServicesPatienteRepository;

    public function __construct(SalaryServiceAssignedsRepository $salaryServiceAssignedsRepo, ConfigSubServicesPatienteRepository $configSubServicesPatienteRepo)
    {
        $this->salaryServiceAssignedsRepository = $salaryServiceAssignedsRepo;
        $this->configSubServicesPatienteRepository = $configSubServicesPatienteRepo;
    }

    /**
     * Display a listing of the SalaryServiceAssigneds.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $salaryServiceAssigneds = SalaryServiceAssigneds::all();
        $services = Service::all();

        return view('salary_service_assigneds.index')
            ->with('salaryServiceAssigneds', $salaryServiceAssigneds)
            ->with('services', $services);
    }

    /**
     * Show the form for creating a new SalaryServiceAssigneds.
     *
     * @return Response
     */
    public function create()
    {
        return view('salary_service_assigneds.create');
    }

    /**
     * Store a newly created SalaryServiceAssigneds in storage.
     *
     * @param CreateSalaryServiceAssignedsRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryServiceAssignedsRequest $request)
    {
        $input = $request->all();

        $salaryServiceAssigneds = $this->salaryServiceAssignedsRepository->create($input);

        $input['salary_service_assigned_id'] = $salaryServiceAssigneds->id;

        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->create($input);

        Flash::success('Salary Service Assigneds saved successfully.');

        return redirect(route('salaryServiceAssigneds.index'));
    }

    /**
     * Display the specified SalaryServiceAssigneds.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agents = User::where('role_id', 5)->get();
        $salaryServiceAssigneds = SalaryServiceAssigneds::where('id', $id)->first();
        $services = SubServices::where('id', $salaryServiceAssigneds->service_id)->first();
        $config = ConfigSubServicesPatiente::where('salary_service_assigned_id', $id)->first();
        $user = User::find($salaryServiceAssigneds->user_id);
        $units = Units::all();

        if (empty($salaryServiceAssigneds)) {
            Flash::error('Salary Service Assigneds not found');

            return redirect(route('salaryServiceAssigneds.index'));
        }

        return view('salary_service_assigneds.show')->with('units', $units)->with('salaryServiceAssigneds', $salaryServiceAssigneds)->with('services', $services)->with('agents', $agents)->with('config', $config)->with('user', $user);
    }

    /**
     * Show the form for editing the specified SalaryServiceAssigneds.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agents = User::where('role_id', 5)->get();
        $salaryServiceAssigneds = SalaryServiceAssigneds::find($id);
        $services = SubServices::find($salaryServiceAssigneds->service_id);
        $config = ConfigSubServicesPatiente::where('salary_service_assigned_id', $id)->first();
        $user = User::find($salaryServiceAssigneds->user_id);
        $units = Units::all();

        if (empty($salaryServiceAssigneds)) {
            Flash::error('Salary Service Assigneds not found');

            return redirect(route('salaryServiceAssigneds.index'));
        }
        return view('salary_service_assigneds.edit')->with('units', $units)->with('salaryServiceAssigneds', $salaryServiceAssigneds)->with('services', $services)->with('agents', $agents)->with('config', $config)->with('user', $user);
    }

    /**
     * Update the specified SalaryServiceAssigneds in storage.
     *
     * @param int $id
     * @param UpdateSalaryServiceAssignedsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $serviceName = SubServices::where('name_sub_service', $data['service_id'])->first();

        $salaryServiceAssigneds = SalaryServiceAssigneds::where('service_id', $serviceName->id)->first();

        if (empty($salaryServiceAssigneds)) {
            Flash::error('Salary Sub Service Assigneds not found');

            return redirect(route('salaryServiceAssigneds.index'));
        }

        $data['service_id'] = $serviceName->id;

        if(isset($data['type_salary'])){
            $data['type_salary'] = true;
        }else{
            $data['type_salary'] = false;
        }

        if($serviceName->price_sub_service == $data['customer_payment']){
            $data['customer_payment'] = NULL;
        }

        if($serviceName->worker_payment == $data['salary']){
            $data['salary'] = NULL;
        }

        $data['created_at'] = now();
        $data['updated_at'] = now();

        $salaryServiceAssigneds = $this->salaryServiceAssignedsRepository->update($data, $id);

        $config = ConfigSubServicesPatiente::where('salary_service_assigned_id', $id)->first();
        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->update($data, $config->id);

        $isPatiente = Patiente::where('id', $data['user_id'])->first();

        Flash::success('Salary Service Assigneds updated successfully.');

        if(!empty($isPatiente) && $isPatiente->role_id == 4){
            return redirect(route('patientes.show', [$isPatiente->id]). '?services');
        }else{
            return redirect(route('workers.show', [$isPatiente->id]). '?services');
        }
    }

    /**
     * Remove the specified SalaryServiceAssigneds from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryServiceAssigneds = $this->salaryServiceAssignedsRepository->find($id);

        if (empty($salaryServiceAssigneds)) {
            Flash::error('Salary Service Assigneds not found');

            return redirect(route('salaryServiceAssigneds.index'));
        }
        
        $config = ConfigSubServicesPatiente::where('salary_service_assigned_id', $id)->first();
        if($config){
            $configSubServicesPatiente = $this->configSubServicesPatienteRepository->delete($config->id);
        }

        $this->salaryServiceAssignedsRepository->delete($id);

        Flash::success('Salary Service Assigneds deleted successfully.');

        return redirect(route('salaryServiceAssigneds.index'));
    }
}
