<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypeDocRequest;
use App\Http\Requests\UpdateTypeDocRequest;
use App\Repositories\TypeDocRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\TypeDoc;
use App\Models\Service;
use App\Models\Role;
use Flash;
use Response;

class TypeDocController extends AppBaseController
{
    /** @var  TypeDocRepository */
    private $typeDocRepository;

    public function __construct(TypeDocRepository $typeDocRepo)
    {
        $this->typeDocRepository = $typeDocRepo;
    }

    /**
     * Display a listing of the TypeDoc.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $typeDocs = TypeDoc::all();
        $services = Service::all();
        $roles = Role::all();

        foreach($typeDocs AS $typeDoc){
            if($typeDoc['service_id'] == '0'){
                $typeDoc['service_id'] = 'ALL';
            }else{
                foreach($services AS $service){
                    if($typeDoc['service_id'] == $service['id']){
                        $typeDoc['service_id'] = $service['name_service'];
                    }
                }
            }
        }

        return view('type_docs.index')
            ->with('typeDocs', $typeDocs)
            ->with('roles', $roles)
            ->with('services', $services);
    }

    /**
     * Show the form for creating a new TypeDoc.
     *
     * @return Response
     */
    public function create()
    {
        $typeDocs = TypeDoc::all();
        $services = Service::all();
        $roles = Role::all();

        return view('type_docs.create')
            ->with('typeDocs', $typeDocs)
            ->with('roles', $roles)
            ->with('services', $services);
    }

    /**
     * Store a newly created TypeDoc in storage.
     *
     * @param CreateTypeDocRequest $request
     *
     * @return Response
     */
    public function store(CreateTypeDocRequest $request)
    {
        $input = $request->all();
        if(isset($input['expired'])){
            $input['expired'] = 1;
        }else{
            $input['expired'] = 0;
        }

        $typeDoc = $this->typeDocRepository->create($input);

        Flash::success('Type Doc saved successfully.');

        return redirect(route('typeDocs.index'));
    }

    /**
     * Display the specified TypeDoc.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $typeDoc = $this->typeDocRepository->find($id);
        $services = Service::all();
        $roles = Role::all();

        if (empty($typeDoc)) {
            Flash::error('Type Doc not found');

            return redirect(route('typeDocs.index'));
        }

        return view('type_docs.show')->with('typeDoc', $typeDoc)->with('services', $services)->with('roles', $roles);
    }

    /**
     * Show the form for editing the specified TypeDoc.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $typeDoc = $this->typeDocRepository->find($id);
        $services = Service::all();
        $roles = Role::all();

        if (empty($typeDoc)) {
            Flash::error('Type Doc not found');

            return redirect(route('typeDocs.index'));
        }

        return view('type_docs.edit')->with('typeDoc', $typeDoc)->with('services', $services)->with('roles', $roles);
    }

    /**
     * Update the specified TypeDoc in storage.
     *
     * @param int $id
     * @param UpdateTypeDocRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();
        $typeDoc = $this->typeDocRepository->find($id);

        if (empty($typeDoc)) {
            Flash::error('Type Doc not found');

            return redirect(route('typeDocs.index'));
        }

        if(isset($input['expired'])){
            $input['expired'] = 1;
        }else{
            $input['expired'] = 0;
        }

        $typeDoc = $this->typeDocRepository->update($input, $id);

        Flash::success('Type Doc updated successfully.');

        return redirect(route('typeDocs.index'));
    }

    /**
     * Remove the specified TypeDoc from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $typeDoc = $this->typeDocRepository->find($id);

        if (empty($typeDoc)) {
            Flash::error('Type Doc not found');

            return redirect(route('typeDocs.index'));
        }

        $typeDocsA = Service::all();
        $countVal = 0;

        if(!empty($typeDocsA) && isset($typeDocsA) && count($typeDocsA) >= 1){
            foreach($typeDocsA as $typeDocs){
                foreach(json_decode($typeDocs->documents) as $val){
                    if($id == $val)
                    $countVal = $countVal + 1;
                }
            }
            if($countVal >= 1){
                Flash::error('you cannot delete this document because it is assigned to one or more services');

                return redirect(route('typeDocs.index'));
            }
        }

        $this->typeDocRepository->delete($id);

        Flash::success('Type Doc deleted successfully.');

        return redirect(route('typeDocs.index'));
    }
}
