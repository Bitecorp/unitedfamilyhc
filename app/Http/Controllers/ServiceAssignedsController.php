<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceAssignedsRequest;
use App\Http\Requests\UpdateServiceAssignedsRequest;
use App\Repositories\ServiceAssignedsRepository;
use App\Models\Service;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Illuminate\Support\Collection;

class ServiceAssignedsController extends AppBaseController
{
    /** @var  ServiceAssignedsRepository */
    private $serviceAssignedsRepository;

    public function __construct(ServiceAssignedsRepository $serviceAssignedsRepo)
    {
        $this->serviceAssignedsRepository = $serviceAssignedsRepo;
    }

    /**
     * Display a listing of the ServiceAssigneds.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $serviceAssigneds = $this->serviceAssignedsRepository->paginate(10);

        return view('service_assigneds.index')
            ->with('serviceAssigneds', $serviceAssigneds);
    }

    /**
     * Show the form for creating a new ServiceAssigneds.
     *
     * @return Response
     */
    public function create()
    {
        $services = Service::all();
        return view('service_assigneds.create')->with('services', $services);
    }

    /**
     * Show the form for creating a new ServiceAssigneds.
     *
     * @return Response
     */
    public function assignedCreate($id)
    {
        $services = Service::all();

        $serviceAssigneds = DB::table('service_assigneds')->select('id', 'services')->where('user_id', $id)->first();

        if(!empty($serviceAssigneds)){

            $collections = collect(json_decode($serviceAssigneds->services));

            $data = [];

            foreach($collections as $collection){
                array_push($data, DB::table('services')->select('id', 'name_service')->where('id', $collection)->first());
            }

            $servicesDist = DB::table('services')->select('id', 'name_service')->get();

            foreach($collections as $collection){
                foreach($services as $key => $service){
                    if($service->id == $collection){
                        unset($servicesDist[$key]);
                    }
                }
            }

            return view('service_assigneds.create')->with('userID', $id)->with('services', $services)->with('collection', collect($data))->with('servicesDist', collect($servicesDist));
        }else{
            return view('service_assigneds.create')->with('userID', $id)->with('services', $services);
        }
    }

    /**
     * Store a newly created ServiceAssigneds in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function assigned($id, Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $id;

        $serviceAssignedsID = DB::table('service_assigneds')->select('id')->where('user_id', $id)->first();

        if(empty($serviceAssignedsID)){
            $input['services'] = json_encode($input['services']);

            $serviceAssigneds = $this->serviceAssignedsRepository->create($input);

            foreach(json_decode($input['services']) as $key => $value){
                DB::table('salary_service_assigneds')->insert([
                    'user_id' => $id,
                    'service_id' => $value
                ]);
            }

            Flash::success('Service Assigneds saved successfully.');

            return redirect(route('workers.show', $id). '?services');
        }else{

            $input['services'] = json_encode($input['services']);

            $serviceAssigneds = $this->serviceAssignedsRepository->update($input, $serviceAssignedsID->id);

            Flash::success('Service Assigneds updated successfully.');

            return redirect(route('workers.show', $id). '?services');
        }
    }

    /**
     * Store a newly created ServiceAssigneds in storage.
     *
     * @param CreateServiceAssignedsRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceAssignedsRequest $request)
    {
        $input = $request->all();

        $serviceAssigneds = $this->serviceAssignedsRepository->create($input);

        Flash::success('Service Assigneds saved successfully.');

        return redirect(route('serviceAssigneds.index'));
    }

    /**
     * Display the specified ServiceAssigneds.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceAssigneds = $this->serviceAssignedsRepository->find($id);

        if (empty($serviceAssigneds)) {
            Flash::error('Service Assigneds not found');

            return redirect(route('serviceAssigneds.index'));
        }

        return view('service_assigneds.show')->with('serviceAssigneds', $serviceAssigneds);
    }

    /**
     * Show the form for editing the specified ServiceAssigneds.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceAssigneds = $this->serviceAssignedsRepository->find($id);

        if (empty($serviceAssigneds)) {
            Flash::error('Service Assigneds not found');

            return redirect(route('serviceAssigneds.index'));
        }

        return view('service_assigneds.edit')->with('serviceAssigneds', $serviceAssigneds);
    }

    /**
     * Update the specified ServiceAssigneds in storage.
     *
     * @param int $id
     * @param UpdateServiceAssignedsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceAssignedsRequest $request)
    {
        $serviceAssigneds = $this->serviceAssignedsRepository->find($id);

        if (empty($serviceAssigneds)) {
            Flash::error('Service Assigneds not found');

            return redirect(route('serviceAssigneds.index'));
        }

        $serviceAssigneds = $this->serviceAssignedsRepository->update($request->all(), $id);

        Flash::success('Service Assigneds updated successfully.');

        return redirect(route('serviceAssigneds.index'));
    }

    /**
     * Remove the specified ServiceAssigneds from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceAssigneds = $this->serviceAssignedsRepository->find($id);

        if (empty($serviceAssigneds)) {
            Flash::error('Service Assigneds not found');

            return redirect(route('serviceAssigneds.index'));
        }

        $this->serviceAssignedsRepository->delete($id);

        Flash::success('Service Assigneds deleted successfully.');

        return redirect(route('serviceAssigneds.index'));
    }
}
