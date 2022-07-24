<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExternalsDocumentsRequest;
use App\Http\Requests\UpdateExternalsDocumentsRequest;
use App\Repositories\ExternalsDocumentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Service;
use App\Models\ExternalsDocuments;
use Flash;
use Response;

class ExternalsDocumentsController extends AppBaseController
{
    /** @var  ExternalsDocumentsRepository */
    private $externalsDocumentsRepository;

    public function __construct(ExternalsDocumentsRepository $externalsDocumentsRepo)
    {
        $this->externalsDocumentsRepository = $externalsDocumentsRepo;
    }

    /**
     * Display a listing of the ExternalsDocuments.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $externalsDocuments = ExternalsDocuments::all();
        $roles = Role::all();
        $services = Service::all();

        return view('externals_documents.index')
            ->with('externalsDocuments', $externalsDocuments)
            ->with('roles', $roles)
            ->with('services', $services);
    }

    /**
     * Show the form for creating a new ExternalsDocuments.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::all();
        $services = Service::all();

        return view('externals_documents.create')
            ->with('roles', $roles)
            ->with('services', $services);
    }

    /**
     * Store a newly created ExternalsDocuments in storage.
     *
     * @param CreateExternalsDocumentsRequest $request
     *
     * @return Response
     */
    public function store(CreateExternalsDocumentsRequest $request)
    {
        $input = $request->all();

        $file = $request->file('file');
        $titleFile = $input['title'];
        $uploadImage = createFile($file, $titleFile);

        $input['file'] = $uploadImage;

        $externalsDocuments = $this->externalsDocumentsRepository->create($input);

        Flash::success('Externals Documents saved successfully.');

        return redirect(route('externalsDocuments.index'));
    }

    /**
     * Display the specified ExternalsDocuments.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $externalsDocuments = $this->externalsDocumentsRepository->find($id);

        if (empty($externalsDocuments)) {
            Flash::error('Externals Documents not found');

            return redirect(route('externalsDocuments.index'));
        }

        return view('externals_documents.show')->with('externalsDocuments', $externalsDocuments);
    }

    /**
     * Show the form for editing the specified ExternalsDocuments.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $externalsDocuments = $this->externalsDocumentsRepository->find($id);
        $roles = Role::all();
        $services = Service::all();

        if (empty($externalsDocuments)) {
            Flash::error('Externals Documents not found');

            return redirect(route('externalsDocuments.index'));
        }

        return view('externals_documents.edit')
            ->with('externalsDocuments', $externalsDocuments)
            ->with('roles', $roles)
            ->with('services', $services);
    }

    /**
     * Update the specified ExternalsDocuments in storage.
     *
     * @param int $id
     * @param UpdateExternalsDocumentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExternalsDocumentsRequest $request)
    {
        $externalsDocuments = $this->externalsDocumentsRepository->find($id);

        if (empty($externalsDocuments)) {
            Flash::error('Externals Documents not found');

            return redirect(route('externalsDocuments.index'));
        }

        $input = $request->all();

        if(isset($input['file'])){
            deleteFile($externalsDocuments->file);
            $file = $request->file('file');
            $titleFile = $input['title'];
            $uploadImage = createFile($file, $titleFile);
            $input['file'] = $uploadImage;
        }

        $externalsDocuments = $this->externalsDocumentsRepository->update($input, $id);

        Flash::success('Externals Documents updated successfully.');

        return redirect(route('externalsDocuments.index'));

    }

    /**
     * Remove the specified ExternalsDocuments from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $externalsDocuments = $this->externalsDocumentsRepository->find($id);

        if (empty($externalsDocuments)) {
            Flash::error('Externals Documents not found');

            return redirect(route('externalsDocuments.index'));
        }

        $deleteImage = deleteFile($externalsDocuments->file);

        $this->externalsDocumentsRepository->delete($id);

        Flash::success('Externals Documents deleted successfully.');

        return redirect(route('externalsDocuments.index'));
    }
}
