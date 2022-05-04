<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalaryServiceAssignedsRequest;
use App\Http\Requests\UpdateSalaryServiceAssignedsRequest;
use App\Repositories\SalaryServiceAssignedsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\SalaryServiceAssigneds;
use App\Models\Service;
use App\Models\SubServices;
use Flash;
use Response;

class SalaryServiceAssignedsController extends AppBaseController
{
    /** @var  SalaryServiceAssignedsRepository */
    private $salaryServiceAssignedsRepository;

    public function __construct(SalaryServiceAssignedsRepository $salaryServiceAssignedsRepo)
    {
        $this->salaryServiceAssignedsRepository = $salaryServiceAssignedsRepo;
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
        $salaryServiceAssigneds = $this->salaryServiceAssignedsRepository->find($id);
        $services = Service::all();

        if (empty($salaryServiceAssigneds)) {
            Flash::error('Salary Service Assigneds not found');

            return redirect(route('salaryServiceAssigneds.index'));
        }

        return view('salary_service_assigneds.show')->with('salaryServiceAssigneds', $salaryServiceAssigneds)->with('services', $services);
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
        $salaryServiceAssigneds = SalaryServiceAssigneds::find($id);
        $services = SubServices::find($salaryServiceAssigneds->service_id);

        if (empty($salaryServiceAssigneds)) {
            Flash::error('Salary Service Assigneds not found');

            return redirect(route('salaryServiceAssigneds.index'));
        }
        return view('salary_service_assigneds.edit')->with('salaryServiceAssigneds', $salaryServiceAssigneds)->with('services', $services);
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

        $salaryServiceAssigneds = $this->salaryServiceAssignedsRepository->update($data, $id);

        Flash::success('Salary Service Assigneds updated successfully.');

        return redirect(route('workers.show', [$data['user_id']]). '?services');
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

        $this->salaryServiceAssignedsRepository->delete($id);

        Flash::success('Salary Service Assigneds deleted successfully.');

        return redirect(route('salaryServiceAssigneds.index'));
    }
}
