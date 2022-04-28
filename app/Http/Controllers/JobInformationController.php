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
use App\Http\Requests\CreateTitleJobsRequest;
use App\Http\Requests\UpdateTitleJobsRequest;
use App\Repositories\TitleJobsRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JobInformationController extends AppBaseController
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

    /** @var  TitleJobsRepository */
    private $titleJobsRepository;

    public function __construct(
        WorkerRepository $personnelRepo,
        JobInformationRepository $jobInformationRepo,
        EducationRepository $educationRepo,
        ContactEmergencyRepository $contactEmergencyRepo,
        ConfirmationIndependentRepository $confirmationIndependentRepo,
        RoleRepository $roleRepo,
        StatuRepository $statuRepo,
        TitleJobsRepository $titleJobsRepo
    )
    {
        $this->personnelRepository = $personnelRepo;
        $this->jobInformationRepository = $jobInformationRepo;
        $this->educationRepository = $educationRepo;
        $this->contactEmergencyRepository = $contactEmergencyRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
        $this->roleRepository = $roleRepo;
        $this->statuRepository = $statuRepo;
        $this->titleJobsRepository = $titleJobsRepo;
    }

    /**
     * Display a listing of the JobInformation.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $jobInformations = $this->jobInformationRepository->paginate(10);

        return view('job_informations.index')->with('jobInformations', $jobInformations);
    }

    /**
     * Show the form for creating a new JobInformation.
     *
     * @return Response
     */
    public function create()
    {
        $titleJobs = DB::table('title_jobs')->select('id', 'name_job')->get();

        return view('job_informations.create')->with('titleJobs', $titleJobs);
    }

    /**
     * Store a newly created JobInformation in storage.
     *
     * @param CreateJobInformationRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->id();

        $jobInformation = $this->jobInformationRepository->create($input);

        Flash::success('Job Information saved successfully.');

        return view('education.create');
    }

    /**
     * Display the specified JobInformation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobInformation = $this->jobInformationRepository->find($id);

        $titleJobs = DB::table('title_jobs')->select('id', 'name_job')->get();

        if (empty($jobInformation)) {
            Flash::error('Job Information not found');

            return redirect(route('jobInformations.index'));
        }

        return view('job_informations.show')->with('jobInformation', $jobInformation)->with('titleJobs', $titleJobs);
    }

    /**
     * Show the form for editing the specified JobInformation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobInformation = $this->jobInformationRepository->find($id);

        if (empty($jobInformation)) {
            Flash::error('Job Information not found');

            return redirect(route('jobInformations.index'));
        }

        $titleJobs = DB::table('title_jobs')->select('id', 'name_job')->get();

        return view('job_informations.edit')->with('jobInformation', $jobInformation)->with('titleJobs', $titleJobs);
    }

    /**
     * Update the specified JobInformation in storage.
     *
     * @param int $id
     * @param UpdateJobInformationRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
        $jobInformation = $this->jobInformationRepository->find($jobInformationID->id);

        if (empty($jobInformation)) {
            Flash::error('Job Information not found');

            return redirect(route('jobInformations.index'));
        }

        $view = 'education.edit';
        $msj = 'Job Information updated successfully.';
        if($jobInformation->work_name_location == ''){
            $view = 'education.create';
            $msj = 'Job Information saved successfully.';
        }

        $data = $request->all();
        $managerID = DB::table('users')->select('id')->where('home_phone', $data['supervisor'])->first();
        $data['supervisor'] = $managerID->id;

        if(isset($data['type_salary'])){
            $data['type_salary'] = true;
        }else{
            $data['type_salary'] = false;
        }

        $jobInformation = $this->jobInformationRepository->update($data, $jobInformationID->id);

        Flash::success($msj);
        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $education = $this->educationRepository->find($educationID->id);

        return view($view)->with('education', $education);
    }

    /**
     * Remove the specified JobInformation from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobInformation = $this->jobInformationRepository->find($id);

        if (empty($jobInformation)) {
            Flash::error('Job Information not found');

            return redirect(route('jobInformations.index'));
        }

        $this->jobInformationRepository->delete($id);

        Flash::success('Job Information deleted successfully.');

        return redirect(route('jobInformations.index'));
    }
}
