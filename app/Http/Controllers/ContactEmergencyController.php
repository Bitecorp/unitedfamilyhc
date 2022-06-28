<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use App\Repositories\WorkerRepository;
use App\Repositories\JobInformationRepository;
use App\Repositories\EducationRepository;
use App\Repositories\ContactEmergencyRepository;
use App\Repositories\ConfirmationIndependentRepository;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateStatuRequest;
use App\Http\Requests\UpdateStatuRequest;
use App\Repositories\StatuRepository;
use Illuminate\Http\Request;
use App\Models\Worker;
use Flash;
use Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ContactEmergencyController extends AppBaseController
{
    /** @var  StatuRepository */
    private $statuRepository;

    /** @var  RoleRepository */
    private $roleRepository;

    /** @var  WorkerRepository */
    private $personnelRepository;

    /** @var  JobInformationRepository */
    private $jobInformationRepository;

     /** @var  EducationRepository */
    private $educationRepository;

    /** @var  ContactEmergencyRepository */
    private $contactEmergencyRepository;

    /** @var  ConfirmationIndependentRepository */
    private $confirmationIndependentRepository;

    public function __construct(
        WorkerRepository $personnelRepo,
        JobInformationRepository $jobInformationRepo,
        EducationRepository $educationRepo,
        ContactEmergencyRepository $contactEmergencyRepo,
        ConfirmationIndependentRepository $confirmationIndependentRepo,
        RoleRepository $roleRepo,
        StatuRepository $estateRepo
    )
    {
        $this->personnelRepository = $personnelRepo;
        $this->jobInformationRepository = $jobInformationRepo;
        $this->educationRepository = $educationRepo;
        $this->contactEmergencyRepository = $contactEmergencyRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
        $this->roleRepository = $roleRepo;
        $this->statuRepository = $estateRepo;
    }

    /**
     * Display a listing of the ContactEmergency.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $contactEmergencies = $this->contactEmergencyRepository->paginate(10);

        return view('contact_emergencies.index')
            ->with('contactEmergencies', $contactEmergencies);
    }

    /**
     * Show the form for creating a new ContactEmergency.
     *
     * @return Response
     */
    public function create()
    {
        return view('contact_emergencies.create');
    }

    /**
     * Store a newly created ContactEmergency in storage.
     *
     * @param CreateContactEmergencyRequest $request
     *
     * @return Response
     */
    public function store(CreateContactEmergencyRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->id();

        $contactEmergency = $this->contactEmergencyRepository->create($input);

        Flash::success('Contact Emergency saved successfully.');

        return view('job_informations.create');
    }

    /**
     * Display the specified ContactEmergency.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contactEmergency = $this->contactEmergencyRepository->find($id);

        if (empty($contactEmergency)) {
            Flash::error('Contact Emergency not found');

            return redirect(route('contactEmergencies.index'));
        }

        return view('contact_emergencies.show')->with('contactEmergency', $contactEmergency);
    }

    /**
     * Show the form for editing the specified ContactEmergency.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contactEmergency = $this->contactEmergencyRepository->find($id);

        if (empty($contactEmergency)) {
            Flash::error('Contact Emergency not found');

            return redirect(route('contactEmergencies.index'));
        }

        return view('contact_emergencies.edit')->with('contactEmergency', $contactEmergency);
    }

    /**
     * Update the specified ContactEmergency in storage.
     *$input
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();
        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('id', '=', $input['idContact'])->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        if (empty($contactEmergency)) {
            Flash::error('Contact Emergency not found');

            return redirect(route('contactEmergencies.index'));
        }

        $view = 'job_informations.edit';
        $msj = 'Contact Emergency update successfully.';

        $userPatiente = Worker::where('id', $id)->first();

        if($contactEmergency->first_name == '' && $userPatiente->role_id != 4){
            $view = 'job_informations.create';
            $msj = 'Contact Emergency saved successfully.';
        }

        if($contactEmergency->guardian == 1){
            $dataPatiente = Worker::find($contactEmergency->user_id);
            $input['mi'] = !empty($input['mi']) ? $input['mi'] : $dataPatiente->mi;
            $input['street_addres'] = !empty($input['street_addres']) ? $input['street_addres'] : $dataPatiente->street_addres;
            $input['apartment_unit'] = !empty($input['apartment_unit']) ? $input['apartment_unit'] : $dataPatiente->apartment_unit;
            $input['city'] = !empty($input['city']) ? $input['city'] : $dataPatiente->city;
            $input['state'] = !empty($input['state']) ? $input['state'] : $dataPatiente->state;
            $input['zip_code'] = !empty($input['zip_code']) ? $input['zip_code'] : $dataPatiente->zip_code;
            $input['home_phone'] = !empty($input['home_phone']) ? $input['home_phone'] : $dataPatiente->home_phone;
            $input['alternate_phone'] = !empty($input['alternate_phone']) ? $input['alternate_phone'] : $dataPatiente->alternate_phone;
        }
            $contactEmergency = $this->contactEmergencyRepository->update($input, $contactEmergencyID->id);


        if($userPatiente->role_id == 2 || $userPatiente->role_id == 3){

            $titleJobs = DB::table('title_jobs')->select('id', 'name_job')->get();

            $workers = DB::table('users')->select('id', 'first_name', 'last_name', 'home_phone')->where('role_id', 1)->where('role_id', 3)->where('user_id', '<>', $contactEmergency->user_id)->get() ?? [];

            Flash::success($msj);

            $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
            $jobInformation = $this->jobInformationRepository->find($jobInformationID->id);

            $locations = DB::table('locations')->select('id', 'name_location')->get();

            return view($view)
            ->with('jobInformation', $jobInformation)
            ->with('titleJobs', $titleJobs)
            ->with('workers', $workers)
            ->with('locations', $locations);
        }elseif($userPatiente->role_id == 4){
            if($contactEmergency->guardian == 0){
                $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $userPatiente->id)->where('guardian', 1)->first();
                $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

                Flash::success('Contact Emergency saved successfully.');

                return view('contact_emergencies.create')->with('patienteID', $userPatiente->id)->with('workerID', $userPatiente->id)->with('contactEmergency', $contactEmergency);
            }elseif($contactEmergency->guardian == 1){
                Flash::success('Guardian saved successfully.');
                return redirect(route('patientes.show', [$contactEmergency->user_id]));
            }
        }
    }

    /**
     * Remove the specified ContactEmergency from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contactEmergency = $this->contactEmergencyRepository->find($id);

        if (empty($contactEmergency)) {
            Flash::error('Contact Emergency not found');

            return redirect(route('contactEmergencies.index'));
        }

        $this->contactEmergencyRepository->delete($id);

        Flash::success('Contact Emergency deleted successfully.');

        return redirect(route('contactEmergencies.index'));
    }
}
