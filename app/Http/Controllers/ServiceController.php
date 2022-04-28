<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Repositories\ServiceRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\ServiceAssigneds;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Illuminate\Support\Collection;

class ServiceController extends AppBaseController
{
    /** @var  ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the Service.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $services = $this->serviceRepository->paginate(10);

        return view('services.index')
            ->with('services', $services);
    }

    /**
     * Show the form for creating a new Service.
     *
     * @return Response
     */
    public function create()
    {
        $docs = DB::table('type_docs')->select('id', 'name_doc')->get();

        return view('services.create')->with('docs', $docs);
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param CreateServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceRequest $request)
    {
        $input = $request->all();
        $input['documents'] = json_encode($input['documents']);
        $service = $this->serviceRepository->create($input);

        Flash::success('Service saved successfully.');

        return redirect(route('services.index'));
    }

    /**
     * Display the specified Service.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $service = $this->serviceRepository->find($id);


        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        return view('services.show')->with('service', $service);
    }

    /**
     * Show the form for editing the specified Service.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        $docs = DB::table('type_docs')->select('id', 'name_doc')->get();

        $collections = collect(json_decode($service->documents));

        $data = [];

        foreach($collections as $collection){
            array_push($data, DB::table('type_docs')->select('id', 'name_doc')->where('id', $collection)->first());
        }

        $docDist = DB::table('type_docs')->select('id', 'name_doc')->get(); /* unset($flowers[1]); */

        foreach($collections as $collection){
            foreach($docs as $key => $doc){
                if($doc->id == $collection){
                    unset($docDist[$key]);
                }
            }
        }

        return view('services.edit')->with('service', $service)->with('docs', $docs)->with('collection', collect($data))->with('docDist', collect($docDist));
    }

    /**
     * Update the specified Service in storage.
     *
     * @param int $id
     * @param UpdateServiceRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        $input = $request->all();

        $input['documents'] = json_encode($input['documents']);

        $service = $this->serviceRepository->update($input, $id);

        Flash::success('Service updated successfully.');

        return redirect(route('services.index'));
    }

    /**
     * Remove the specified Service from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        $this->serviceRepository->delete($id);

        Flash::success('Service deleted successfully.');

        return redirect(route('services.index'));
    }
}
