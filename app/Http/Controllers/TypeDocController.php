<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypeDocRequest;
use App\Http\Requests\UpdateTypeDocRequest;
use App\Repositories\TypeDocRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\TypeDoc;
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

        return view('type_docs.index')
            ->with('typeDocs', $typeDocs);
    }

    /**
     * Show the form for creating a new TypeDoc.
     *
     * @return Response
     */
    public function create()
    {
        $typeDocs = TypeDoc::all();
        return view('type_docs.create')
            ->with('typeDocs', $typeDocs);
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

        if (empty($typeDoc)) {
            Flash::error('Type Doc not found');

            return redirect(route('typeDocs.index'));
        }

        return view('type_docs.show')->with('typeDoc', $typeDoc);
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

        if (empty($typeDoc)) {
            Flash::error('Type Doc not found');

            return redirect(route('typeDocs.index'));
        }

        return view('type_docs.edit')->with('typeDoc', $typeDoc);
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

        $this->typeDocRepository->delete($id);

        Flash::success('Type Doc deleted successfully.');

        return redirect(route('typeDocs.index'));
    }
}
