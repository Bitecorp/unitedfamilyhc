<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImagesDocumentsRequest;
use App\Http\Requests\UpdateImagesDocumentsRequest;
use App\Repositories\ImagesDocumentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ImagesDocumentsController extends AppBaseController
{
    /** @var  ImagesDocumentsRepository */
    private $imagesDocumentsRepository;

    public function __construct(ImagesDocumentsRepository $imagesDocumentsRepo)
    {
        $this->imagesDocumentsRepository = $imagesDocumentsRepo;
    }

    /**
     * Display a listing of the ImagesDocuments.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $imagesDocuments = $this->imagesDocumentsRepository->paginate(10);

        return view('images_documents.index')
            ->with('imagesDocuments', $imagesDocuments);
    }

    /**
     * Show the form for creating a new ImagesDocuments.
     *
     * @return Response
     */
    public function create()
    {
        return view('images_documents.create');
    }

    /**
     * Store a newly created ImagesDocuments in storage.
     *
     * @param CreateImagesDocumentsRequest $request
     *
     * @return Response
     */
    public function store(CreateImagesDocumentsRequest $request)
    {
        $input = $request->all();

        $file = $request->file('file');
        $titleFile = $input['title'];
        $uploadImage = createFile($file, $titleFile);

        $input['file'] = $uploadImage;

        $imagesDocuments = $this->imagesDocumentsRepository->create($input);

        Flash::success('Images Documents saved successfully.');

        return redirect(route('imagesDocuments.index'));
    }

    /**
     * Display the specified ImagesDocuments.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $imagesDocuments = $this->imagesDocumentsRepository->find($id);

        if (empty($imagesDocuments)) {
            Flash::error('Images Documents not found');

            return redirect(route('imagesDocuments.index'));
        }

        return view('images_documents.show')->with('imagesDocuments', $imagesDocuments);
    }

    /**
     * Show the form for editing the specified ImagesDocuments.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $imagesDocuments = $this->imagesDocumentsRepository->find($id);

        if (empty($imagesDocuments)) {
            Flash::error('Images Documents not found');

            return redirect(route('imagesDocuments.index'));
        }

        return view('images_documents.edit')->with('imagesDocuments', $imagesDocuments);
    }

    /**
     * Update the specified ImagesDocuments in storage.
     *
     * @param int $id
     * @param UpdateImagesDocumentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateImagesDocumentsRequest $request)
    {
        $imagesDocuments = $this->imagesDocumentsRepository->find($id);

        if (empty($imagesDocuments)) {
            Flash::error('Images Documents not found');

            return redirect(route('imagesDocuments.index'));
        }

        $input = $request->all();

        $deleteImage = deleteFile($imagesDocuments->file);

        $file = $request->file('file');
        $titleFile = $input['title'];
        $uploadImage = createFile($file, $titleFile);
        $input['file'] = $uploadImage;

        $imagesDocuments = $this->imagesDocumentsRepository->update($input, $id);

        Flash::success('Images Documents updated successfully.');

        return redirect(route('imagesDocuments.index'));

    }

    /**
     * Remove the specified ImagesDocuments from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $imagesDocuments = $this->imagesDocumentsRepository->find($id);

        if (empty($imagesDocuments)) {
            Flash::error('Images Documents not found');

            return redirect(route('imagesDocuments.index'));
        }

        $deleteImage = deleteFile($imagesDocuments->file);

        $this->imagesDocumentsRepository->delete($id);

        Flash::success('Images Documents deleted successfully.');

        return redirect(route('imagesDocuments.index'));
    }
}
