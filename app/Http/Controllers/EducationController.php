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
use App\Http\Requests\CreateReferencesPersonalesRequest;
use App\Http\Requests\UpdateReferencesPersonalesRequest;
use App\Repositories\ReferencesPersonalesRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EducationController extends AppBaseController
{
    /** @var  ReferencesPersonalesRepository */
    private $referencesPersonalesRepository;

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
        StatuRepository $statuRepo,
        ReferencesPersonalesRepository $referencesPersonalesRepo
    )
    {
        $this->personnelRepository = $personnelRepo;
        $this->jobInformationRepository = $jobInformationRepo;
        $this->educationRepository = $educationRepo;
        $this->contactEmergencyRepository = $contactEmergencyRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
        $this->roleRepository = $roleRepo;
        $this->statuRepository = $statuRepo;
        $this->referencesPersonalesRepository = $referencesPersonalesRepo;
    }

    /**
     * Display a listing of the Education.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $education = $this->educationRepository->paginate(10);

        return view('education.index')
            ->with('education', $education);
    }

    /**
     * Show the form for creating a new Education.
     *
     * @return Response
     */
    public function create()
    {
        return view('education.create');
    }

    /**
     * Store a newly created Education in storage.
     *
     * @param CreateEducationRequest $request
     *
     * @return Response
     */
    public function store(CreateEducationRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->id();

        $education = $this->educationRepository->create($input);

        Flash::success('Education saved successfully.');

        return view('confirmation_independents.create');
    }

    /**
     * Display the specified Education.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $education = $this->educationRepository->find($id);

        if (empty($education)) {
            Flash::error('Education not found');

            return redirect(route('education.index'));
        }

        return view('education.show')->with('education', $education);
    }

    /**
     * Show the form for editing the specified Education.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $education = $this->educationRepository->find($id);

        if (empty($education)) {
            Flash::error('Education not found');

            return redirect(route('education.index'));
        }

        return view('education.edit')->with('education', $education);
    }

    /**
     * Update the specified Education in storage.
     *
     * @param int $id
     * @param UpdateEducationRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $education = $this->educationRepository->find($educationID->id);

        $referenceOneID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '1')->first();
        $referenceOne = $this->referencesPersonalesRepository->find($referenceOneID->id);

        if (empty($education)) {
            Flash::error('Education not found');

            return redirect(route('education.index'));
        }

        $view = 'references_personales.edit';
        $msj = 'Education updated successfully.';
        if($referenceOne->name_job == ''){
            $view = 'references_personales.create';
            $msj = 'Education saved successfully.';
        }

        $education = $this->educationRepository->update($request->all(), $educationID->id);

        Flash::success($msj);
        return view($view)->with('referenceOne', $referenceOne);
    }

    /**
     * Remove the specified Education from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $education = $this->educationRepository->find($id);

        if (empty($education)) {
            Flash::error('Education not found');

            return redirect(route('education.index'));
        }

        $this->educationRepository->delete($id);

        Flash::success('Education deleted successfully.');

        return redirect(route('education.index'));
    }
}
