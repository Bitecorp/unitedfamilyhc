<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAlertDocumentsRequest;
use App\Http\Requests\UpdateAlertDocumentsRequest;
use App\Repositories\AlertDocumentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\ServiceAssigneds;
use App\Models\Companies;
use App\Models\Role;
use App\Models\Statu;
use App\Models\Service;
use App\Models\MaritalStatus;
use App\Models\TitleJobs;
use App\Models\TypeDoc;
use App\Models\User;
use App\Models\ConfirmationIndependent;
use App\Models\Education;
use App\Models\JobInformation;
use App\Models\ContactEmergency;
use App\Models\documentsEditors;
use App\Models\DocumentUserFiles;
use App\Models\Location;
use App\Models\SalaryServiceAssigneds;
use App\Models\ReferencesJobs;
use App\Models\ReferencesJobsTwo;
use App\Models\ReferencesPersonales;
use App\Models\ReferencesPersonalesTwo;
use App\Models\AlertDocumentsExpired;
use Mail;
use App\Mail\updateDocuments;

class AlertDocumentsController extends AppBaseController
{
    /** @var AlertDocumentsRepository $alertDocumentsRepository*/
    private $alertDocumentsRepository;

    public function __construct(AlertDocumentsRepository $alertDocumentsRepo)
    {
        $this->alertDocumentsRepository = $alertDocumentsRepo;
    }

    /**
     * Display a listing of the AlertDocuments.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();

        $status = Statu::all();

        $servicesAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $maritalStatus = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        $alertDocuments = AlertDocumentsExpired::all();

        $dataDocuments = [];
        $workers = [];
        foreach($alertDocuments AS $key => $alertDocument){
            array_push($dataDocuments, DocumentUserFiles::find($alertDocument->document_user_file_id));
        }

        foreach($dataDocuments AS $key => $dataDocument){
            if(isset($dataDocument) && !empty($dataDocument)){
                $dataUser = User::find($dataDocument['user_id']);
            }
            if(isset($dataUser) && !empty($dataUser)){
                array_push($workers, $dataUser);
            }
        }

        $confirmationIndependents = ConfirmationIndependent::all();

        $contactEmergencies = ContactEmergency::all();

        $educations = Education::all();

        $jobInformations = JobInformation::all();

        return view('alert_documents.index')
        ->with('roles', $roles)
        ->with('status', $status)
        ->with('confirmationIndependents', $confirmationIndependents)
        ->with('contactEmergencies', $contactEmergencies)
        ->with('jobInformations', $jobInformations)
        ->with('workers', array_unique($workers))
        ->with('servicesAssigned', $servicesAssigned)
        ->with('educations', $educations)
        ->with('maritalStatus', $maritalStatus);
    }

    /**
     * Send Email User.
     *
     * @param int $idUser
     *
     *
     * @return Response
     */
    public function sendEmail($idUser)
    {
        $infoUser = User::where('id', $idUser)->first() ?? '';

        if (empty($infoUser)) {
            Flash::error('User not found');

            return redirect(route('alertDocuments.index'));
        }

        if(isset($infoUser) && !empty($infoUser)){
        $documentsUser = DocumentUserFiles::where('user_id', $infoUser->id)->where('expired', 1)->get() ?? [];
            if(isset($documentsUser) && !empty($documentsUser) && count($documentsUser) > 0){
                foreach($documentsUser AS $keyD => $documentUser){
                    $infoDocs = TypeDoc::where('id', $documentUser->document_id)->get() ?? [];
                    if(isset($infoDocs) && !empty($infoDocs) && count($infoDocs) > 0){
                        Mail::to($infoUser->email)->send(new updateDocuments($infoUser, $infoDocs));
                    }
                }
            }
        }

        Flash::success('Send Email successfully.');

        return redirect(route('alertDocuments.index'));

    }

    /**
     * Display a listing of the AlertDocuments.
     *
     * @return Response
     */
    public function sendEmailFull()
    {
        $dataDocumentsExpired = AlertDocumentsExpired::all();

        if(!empty($dataDocumentsExpired)){
            foreach($dataDocumentsExpired AS $dataDocumentExpired){
                $dataDocument = DocumentUserFiles::where('id', $dataDocumentExpired->document_user_file_id)->first();
                $infoUser = User::where('id', $dataDocument->user_id)->first() ?? '';

                if(isset($infoUser) && !empty($infoUser)){
                $documentsUser = DocumentUserFiles::where('user_id', $infoUser->id)->where('expired', 1)->get() ?? [];
                    if(isset($documentsUser) && !empty($documentsUser) && count($documentsUser) > 0){
                        foreach($documentsUser AS $keyD => $documentUser){
                            $infoDocs = TypeDoc::where('id', $documentUser->document_id)->get() ?? [];
                            if(isset($infoDocs) && !empty($infoDocs) && count($infoDocs) > 0){
                                Mail::to($infoUser->email)->send(new updateDocuments($infoUser, $infoDocs));
                            }
                        }
                    }
                }

            }
        }

        Flash::success('Send Emails successfully.');

        return redirect(route('alertDocuments.index'));

    }

    /**
     * Show the form for creating a new AlertDocuments.
     *
     * @return Response
     */
    public function create()
    {
        return view('alert_documents.create');
    }

    /**
     * Store a newly created AlertDocuments in storage.
     *
     * @param CreateAlertDocumentsRequest $request
     *
     * @return Response
     */
    public function store(CreateAlertDocumentsRequest $request)
    {
        $input = $request->all();

        $alertDocuments = $this->alertDocumentsRepository->create($input);

        Flash::success('Alert Documents saved successfully.');

        return redirect(route('alertDocuments.index'));
    }

    /**
     * Display the specified AlertDocuments.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $infoUser = User::where('id', $id)->first();

        if (empty($infoUser)) {
            Flash::error('User not found');

            return redirect(route('alertDocuments.index'));
        }

        if(isset($infoUser) && !empty($infoUser)){
        $documentsUser = DocumentUserFiles::where('user_id', $infoUser->id)->where('expired', 1)->get() ?? [];
            if(isset($documentsUser) && !empty($documentsUser) && count($documentsUser) > 0){
                foreach($documentsUser AS $keyD => $documentUser){
                    $infoDocs = TypeDoc::where('id', $documentUser->document_id)->get() ?? [];
                    if(isset($infoDocs) && !empty($infoDocs) && count($infoDocs) > 0){
                        Mail::to($infoUser->email)->send(new updateDocuments($infoUser, $infoDocs));
                    }
                }
            }
        }

        Flash::success('Send Email successfully.');

        return redirect(route('alertDocuments.index'));
    }

    /**
     * Show the form for editing the specified AlertDocuments.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $alertDocuments = $this->alertDocumentsRepository->find($id);

        if (empty($alertDocuments)) {
            Flash::error('Alert Documents not found');

            return redirect(route('alertDocuments.index'));
        }

        return view('alert_documents.edit')->with('alertDocuments', $alertDocuments);
    }

    /**
     * Update the specified AlertDocuments in storage.
     *
     * @param int $id
     * @param UpdateAlertDocumentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAlertDocumentsRequest $request)
    {
        $alertDocuments = $this->alertDocumentsRepository->find($id);

        if (empty($alertDocuments)) {
            Flash::error('Alert Documents not found');

            return redirect(route('alertDocuments.index'));
        }

        $alertDocuments = $this->alertDocumentsRepository->update($request->all(), $id);

        Flash::success('Alert Documents updated successfully.');

        return redirect(route('alertDocuments.index'));
    }

    /**
     * Remove the specified AlertDocuments from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $alertDocuments = $this->alertDocumentsRepository->find($id);

        if (empty($alertDocuments)) {
            Flash::error('Alert Documents not found');

            return redirect(route('alertDocuments.index'));
        }

        $this->alertDocumentsRepository->delete($id);

        Flash::success('Alert Documents deleted successfully.');

        return redirect(route('alertDocuments.index'));
    }


}
