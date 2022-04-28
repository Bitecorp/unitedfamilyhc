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
use App\Models\Worker;
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
            array_push($workers, Worker::find($dataDocument->user_id));
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
        $alertDocuments = $this->alertDocumentsRepository->find($id);

        if (empty($alertDocuments)) {
            Flash::error('Alert Documents not found');

            return redirect(route('alertDocuments.index'));
        }

        return view('alert_documents.show')->with('alertDocuments', $alertDocuments);
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
