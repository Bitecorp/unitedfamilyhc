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
use App\Repositories\CompaniesRepository;
use Flash;
use Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;

class ConfirmationIndependentController extends AppBaseController
{
    /** @var  CompaniesRepository */
    private $companiesRepository;

    /** @var  StatuRepository */
    private $statuRepository;

    /** @var  RoleRepository */
    private $roleRepository;

    /** @var  WorkerRepository */
    private $workerRepository;

    /** @var  JobInformationRepository */
    private $jobInformationRepository;

     /** @var  EducationRepository */
    private $educationRepository;

    /** @var  ContactEmergencyRepository */
    private $contactEmergencyRepository;

    /** @var  ConfirmationIndependentRepository */
    private $confirmationIndependentRepository;

    public function __construct(
        WorkerRepository $workerRepo,
        JobInformationRepository $jobInformationRepo,
        EducationRepository $educationRepo,
        ContactEmergencyRepository $contactEmergencyRepo,
        ConfirmationIndependentRepository $confirmationIndependentRepo,
        RoleRepository $roleRepo,
        StatuRepository $statuRepo,
        CompaniesRepository $companiesRepo
    )
    {
        $this->workerRepository = $workerRepo;
        $this->jobInformationRepository = $jobInformationRepo;
        $this->educationRepository = $educationRepo;
        $this->contactEmergencyRepository = $contactEmergencyRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
        $this->roleRepository = $roleRepo;
        $this->statuRepository = $statuRepo;
        $this->companiesRepository = $companiesRepo;
    }

    /**
     * Display a listing of the ConfirmationIndependent.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $confirmationIndependents = $this->confirmationIndependentRepository->paginate(10);

        return view('confirmation_independents.index')
            ->with('confirmationIndependents', $confirmationIndependents);
    }

    /**
     * Show the form for creating a new ConfirmationIndependent.
     *
     * @return Response
     */
    public function create()
    {
        return view('confirmation_independents.create');
    }

    /**
     * Store a newly created ConfirmationIndependent in storage.
     *
     * @param CreateConfirmationIndependentRequest $request
     *
     * @return Response
     */
    public function store(CreateConfirmationIndependentRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->id();

        $confirmationIndependent = $this->confirmationIndependentRepository->create($input);

        Flash::success('Confirmation Independent saved successfully.');
        Flash::success('New Worker entered correctly.');

        /* return view('workers.index'); */
        return redirect(route('workers.index'));
    }

    /**
     * Display the specified ConfirmationIndependent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $confirmationIndependent = $this->confirmationIndependentRepository->find($id);

        $companiesID = DB::table('companies')->select('id')->where('user_id', '=', $id)->first();

        if (empty($confirmationIndependent)) {
            Flash::error('Confirmation Independent not found');

            return redirect(route('confirmationIndependents.index'));
        }

        if(!empty($companiesID)){
            $companies = $this->companiesRepository->find($companiesID->id);
            return view('confirmation_independents.show')
            ->with('confirmationIndependent', $confirmationIndependent)
            ->with('companies', $companies);
        }else{
            return view('confirmation_independents.show')
            ->with('confirmationIndependent', $confirmationIndependent);
        }
    }

    /**
     * Show the form for editing the specified ConfirmationIndependent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $confirmationIndependent = $this->confirmationIndependentRepository->find($id);

        if (empty($confirmationIndependent)) {
            Flash::error('Confirmation Independent not found');

            return redirect(route('confirmationIndependents.index'));
        }

        return view('confirmation_independents.edit')->with('confirmationIndependent', $confirmationIndependent);
    }

    /**
     * Update the specified ConfirmationIndependent in storage.
     *
     * @param int $id
     * @param UpdateConfirmationIndependentRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $confirmationIndependent = $this->confirmationIndependentRepository->find($confirmationIndependentID->id);

        if (empty($confirmationIndependent)) {
            Flash::error('Confirmation Independent not found');

            return redirect(route('confirmationIndependents.index'));
        }

        $input = $request->all();
        if(isset($input['independent_contractor']) && $input['independent_contractor'] == '2'){
            if(isset($input['personalEmpresa'])){
                $input['personalEmpresa'] = '0';
            }else{
                $input['personalEmpresa'] = '0';
            }
        }

        $companiesID = DB::table('companies')->select('id')->where('user_id', '=', $id)->first();

        if(!empty($companiesID) && (isset($input['independent_contractor']) && $input['independent_contractor'] == '1') && (isset($input['personalEmpresa']) && $input['personalEmpresa'] == '2')){
            $input['user_id'] = $id;
            $companies = $this->companiesRepository->update($input, $companiesID->id);
        }elseif((isset($input['independent_contractor']) && $input['independent_contractor'] == '1') && (isset($input['personalEmpresa']) && $input['personalEmpresa'] == '2')){
            $input['user_id'] = $id;
            $companies = $this->companiesRepository->create($input);
        }

        if((!empty($companiesID) && isset($input['independent_contractor']) && $input['independent_contractor'] == '1' && isset($input['personalEmpresa']) && $input['personalEmpresa'] == '1')
        || (!empty($companiesID) && isset($input['independent_contractor']) && $input['independent_contractor'] == '2')){
            $this->companiesRepository->delete($companiesID->id);
        }

        $confirmationIndependent = $this->confirmationIndependentRepository->update($input, $confirmationIndependentID->id);

        Flash::success('Data loaded successfully');
        if(Auth::user()->role_id == 2){
            return redirect(route('home'));
        }else{
            return redirect(route('workers.show', [$confirmationIndependent->user_id]));
        }
    }

    /**
     * Remove the specified ConfirmationIndependent from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $confirmationIndependent = $this->confirmationIndependentRepository->find($id);

        if (empty($confirmationIndependent)) {
            Flash::error('Confirmation Independent not found');

            return redirect(route('confirmationIndependents.index'));
        }

        $this->confirmationIndependentRepository->delete($id);

        Flash::success('Confirmation Independent deleted successfully.');

        return redirect(route('confirmationIndependents.index'));
    }
}
