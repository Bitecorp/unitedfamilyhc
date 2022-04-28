<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentUserFilesRequest;
use App\Http\Requests\UpdateDocumentUserFilesRequest;
use App\Repositories\DocumentUserFilesRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\ServiceAssigneds;
use Illuminate\Http\Request;
use App\Models\documentsEditors;
use App\Models\DocumentUserFiles;
use App\Models\AlertDocumentsExpired;
use App\Models\TypeDoc;
use Flash;
use Response;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DocumentUserFilesController extends AppBaseController
{
    /** @var  DocumentUserFilesRepository */
    private $documentUserFilesRepository;

    public function __construct(DocumentUserFilesRepository $documentUserFilesRepo)
    {
        $this->documentUserFilesRepository = $documentUserFilesRepo;
    }

    /**
     * Display a listing of the DocumentUserFiles.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $documentUserFiles = $this->documentUserFilesRepository->paginate(10);

        return view('document_user_files.index')
            ->with('documentUserFiles', $documentUserFiles);
    }

    /**
     * Display a listing of the DocumentUserFiles.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function docsFileList($id, Request $request)
    {
        $servicesAssingneds = DB::table('service_assigneds')->select('services')->where('user_id', $id)->first();
        $dataServicesAssigneds = [];

        foreach(collect(json_decode($servicesAssingneds->services)) as $key => $value){
            array_push($dataServicesAssigneds, DB::table('services')->select('documents')->where('id', $value)->first());
        }

        $dataListFiles = [];
        foreach($dataServicesAssigneds as $key => $values){
            foreach(json_decode($values->documents) as $key => $value){
                array_push($dataListFiles, DB::table('type_docs')->select('id')->where('id', $value)->first());
            }
        }

        $dataListFilesClear = [];
        foreach(collect($dataListFiles) as $key => $val){
            array_push($dataListFilesClear, $val->id);
        }

        $documentUserFiles = [];
        foreach(array_unique($dataListFilesClear) as $key => $valID){
            array_push($documentUserFiles,  DB::table('type_docs')->select('id', 'name_doc')->where('id', $valID)->first());
        }

        /* $documentUserFiles = collect($documentUserFiles); */
        $filesUploads = collect(DB::table('document_user_files')->select('id', 'document_id', 'date_expedition', 'date_expired', 'file')->where('user_id', $id)->get());

        $documentUserFilesUpload = array();
        foreach($filesUploads AS $key => $value){
            array_push($documentUserFilesUpload, DB::table('type_docs')->select('id', 'name_doc')->where('id', $value->document_id)->first());
        }

        $documentUserFilesIDsA = array();
        foreach($documentUserFiles AS $key => $value){
            array_push($documentUserFilesIDsA, $value->id);
        }

        $documentUserFilesIDsU = array();
        foreach($documentUserFilesUpload AS $key => $value){
            array_push($documentUserFilesIDsU, $value->id);
        }

        $idDIff = array_diff($documentUserFilesIDsA, $documentUserFilesIDsU);

        $documentUserFilesDinst = array();
        foreach($idDIff AS $key => $value){
            array_push($documentUserFilesDinst, DB::table('type_docs')->select('id', 'name_doc')->where('id', $value)->first());
        }

        return view('document_user_files.index')->with('documentUserFiles', collect($documentUserFiles))->with('userID', $id)->with('filesUploads', !empty($filesUploads) ? $filesUploads : '')->with('documentUserFiles', !empty($documentUserFiles) ? collect($documentUserFiles) : '')
            ->with('documentUserFilesUploads', !empty($documentUserFilesUpload) ? collect($documentUserFilesUpload) : '')
            ->with('documentUserFilesDiffs', !empty($documentUserFilesDinst) ? collect($documentUserFilesDinst) : '');
    }

    /**
     * Show the form for creating a new DocumentUserFiles.
     *
     * @return Response
     */
    public function create($id)
    {

        return view('document_user_files.create');
    }

    /**
     * Show the form for creating a new DocumentUserFiles.
     *
     * @return Response
     */
    public function docFileCreate($userID, $docID, Request $request)
    {
        $typeDoc = TypeDoc::where('id', $docID)->first();
        return view('document_user_files.create')->with('docID', $docID)->with('userID', $userID)->with('typeDoc', $typeDoc);
    }

    /**
     * Show the form for creating a new DocumentUserFiles.
     *
     * @return Response
     */
    public function docFileUpdate($userID, $fileID, $docID, Request $request)
    {
        $file = DocumentUserFiles::where('user_id', $userID)->where('document_id', $docID)->where('id', $fileID)->first();
        return view('document_user_files.edit')->with('docID', $docID)->with('userID', $userID)->with('documentUserFiles', $file)->with('fileID', $fileID);
    }

    /**
     * Store a newly created DocumentUserFiles in storage.
     *
     * @param CreateDocumentUserFilesRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentUserFilesRequest $request)
    {
        $input = $request->all();

        $documentUserFiles = $this->documentUserFilesRepository->create($input);

        Flash::success('Document User Files saved successfully.');

        return redirect(route('documentUserFiles.index'));
    }

    /**
     * Store a newly created DocumentUserFiles in storage.
     *
     * @param CreateDocumentUserFilesRequest $request
     *
     * @return Response
     */
    public function docFileUpload($userID, $docID, CreateDocumentUserFilesRequest $request)
    {

        $input = $request->all();

        $documentStatus = DocumentUserFiles::where('user_id', $userID)->where('document_id', $docID)->where('expired', '1')->get();
        if(isset($documentStatus) && !empty($documentStatus)){
            foreach($documentStatus AS $key => $value){
                DocumentUserFiles::where('id', $value->id)->update(['expired' => '2']);
                AlertDocumentsExpired::where('document_user_file_id', $value->id)->delete();
            }
        }

        $file = $request->file('file');
        $titleFile = '';
        $uploadImage = createFile($file, $titleFile);

        $input['file'] = $uploadImage;
        $input['user_id'] = $userID;
        $input['document_id'] = $docID;

        $documentUserFiles = $this->documentUserFilesRepository->create($input);

        Flash::success('Document User Files saved successfully.');
        return redirect(route('workers.show', [$userID]));
    }

    /**
     * Store a newly created DocumentUserFiles in storage.
     *
     * @param CreateDocumentUserFilesRequest $request
     *
     * @return Response
     */
    public function docFileUploadUpdate($userID, $fileID, $docID, CreateDocumentUserFilesRequest $request)
    {

        $documentUserFiles = $this->documentUserFilesRepository->find($fileID);

        if (empty($documentUserFiles)) {
            Flash::error('Document User Files not found');

            return redirect(route('workers.show', [$userID]));
        }

        $deleteImage = deleteFile($documentUserFiles->file);

        if($deleteImage){
            $this->documentUserFilesRepository->delete($fileID);
        }

        $input = $request->all();

        $documentStatus = DocumentUserFiles::where('user_id', $userID)->where('document_id', $docID)->where('expired', '1')->get();
        if(isset($documentStatus) && !empty($documentStatus)){
            foreach($documentStatus AS $key => $value){
                DocumentUserFiles::where('id', $value->id)->update(['expired' => '2']);
                AlertDocumentsExpired::where('document_user_file_id', $value->id)->delete();
            }
        }

        $file = $request->file('file');
        $titleFile = '';
        $uploadImage = createFile($file, $titleFile);

        $input['file'] = $uploadImage;
        $input['user_id'] = $userID;
        $input['document_id'] = $docID;

        $documentUserFile = $this->documentUserFilesRepository->create($input);

        Flash::success('Document User Files saved successfully.');

        return redirect(route('workers.show', [$userID]));
    }

    /**
     * Display the specified DocumentUserFiles.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentUserFiles = DocumentUserFiles::all();
        $documentsEditors = documentsEditors::all();

        if (empty($documentUserFiles)) {
            Flash::error('Document User Files not found');

            return redirect(route('documentUserFiles.index'));
        }

        return view('document_user_files.show')->with('documentUserFiles', $documentUserFiles);
    }

    /**
     * Show the form for editing the specified DocumentUserFiles.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $documentUserFiles = $this->documentUserFilesRepository->find($id);

        if (empty($documentUserFiles)) {
            Flash::error('Document User Files not found');

            return redirect(route('documentUserFiles.index'));
        }

        return view('document_user_files.edit')->with('documentUserFiles', $documentUserFiles);
    }

    /**
     * Update the specified DocumentUserFiles in storage.
     *
     * @param int $id
     * @param UpdateDocumentUserFilesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentUserFilesRequest $request)
    {
        $documentUserFiles = $this->documentUserFilesRepository->find($id);

        if (empty($documentUserFiles)) {
            Flash::error('Document User Files not found');

            return redirect(route('documentUserFiles.index'));
        }

        $documentUserFiles = $this->documentUserFilesRepository->update($request->all(), $id);

        Flash::success('Document User Files updated successfully.');

        return redirect(route('documentUserFiles.index'));
    }

    /**
     * Remove the specified DocumentUserFiles from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $documentUserFiles = $this->documentUserFilesRepository->find($id);

        if (empty($documentUserFiles)) {
            Flash::error('Document User Files not found');

            return redirect(route('documentUserFiles.index'));
        }

        $userID = $documentUserFiles->user_id;

        $deleteImage = deleteFile($documentUserFiles->file);

        if($deleteImage){
            $this->documentUserFilesRepository->delete($id);

            Flash::success('Document User Files deleted successfully.');

            return redirect(route('workers.show', [$userID]));
        }
    }
}
