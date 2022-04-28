<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReferencesJobsTwoRequest;
use App\Http\Requests\UpdateReferencesJobsTwoRequest;
use App\Repositories\ReferencesJobsTwoRepository;
use App\Repositories\ConfirmationIndependentRepository;
use App\Repositories\EducationRepository;
use App\Repositories\CompaniesRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReferencesPersonalesTwoRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;

class ReferencesJobsTwoController extends AppBaseController
{
    /** @var  ReferencesJobsTwoRepository */
    private $referencesJobsTwoRepository;

    /** @var  EducationRepository */
    private $educationRepository;

    /** @var  ConfirmationIndependentRepository */
    private $confirmationIndependentRepository;

    /** @var  CompaniesRepository */
    private $companiesRepository;

    /** @var  ReferencesPersonalesTwoRepository */
    private $referencesPersonalesTwoRepository;

    public function __construct(
        ReferencesJobsTwoRepository $referencesJobsTwoRepo,
        EducationRepository $educationRepo,
        ConfirmationIndependentRepository $confirmationIndependentRepo,
        CompaniesRepository $companiesRepo,
        ReferencesPersonalesTwoRepository $referencesPersonalesTwoRepo
    )
    {
        $this->referencesJobsTwoRepository = $referencesJobsTwoRepo;
        $this->educationRepository = $educationRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
        $this->companiesRepository = $companiesRepo;
        $this->referencesPersonalesTwoRepository = $referencesPersonalesTwoRepo;
    }

    /**
     * Display a listing of the ReferencesJobsTwo.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $referencesJobsTwos = $this->referencesJobsTwoRepository->paginate(10);

        return view('references_jobs_twos.index')
            ->with('referencesJobsTwos', $referencesJobsTwos);
    }

    /**
     * Show the form for creating a new ReferencesJobsTwo.
     *
     * @return Response
     */
    public function create()
    {
        return view('references_jobs_twos.create');
    }

    /**
     * Store a newly created ReferencesJobsTwo in storage.
     *
     * @param CreateReferencesJobsTwoRequest $request
     *
     * @return Response
     */
    public function store(CreateReferencesJobsTwoRequest $request)
    {
        $input = $request->all();

        $referencesJobsTwo = $this->referencesJobsTwoRepository->create($input);

        Flash::success('References Jobs Two saved successfully.');

        return redirect(route('referencesJobsTwos.index'));
    }

    /**
     * Display the specified ReferencesJobsTwo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $referencesJobsTwo = $this->referencesJobsTwoRepository->find($id);

        if (empty($referencesJobsTwo)) {
            Flash::error('References Jobs Two not found');

            return redirect(route('referencesJobsTwos.index'));
        }

        return view('references_jobs_twos.show')->with('referencesJobsTwo', $referencesJobsTwo);
    }

    /**
     * Show the form for editing the specified ReferencesJobsTwo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $referencesJobsTwo = $this->referencesJobsTwoRepository->find($id);

        if (empty($referencesJobsTwo)) {
            Flash::error('References Jobs Two not found');

            return redirect(route('referencesJobsTwos.index'));
        }

        return view('references_jobs_twos.edit')->with('referencesJobsTwo', $referencesJobsTwo);
    }

    /**
     * Update the specified ReferencesJobsTwo in storage.
     *
     * @param int $id
     * @param UpdateReferencesJobsTwoRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $referenceTwoID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referencesJobsTwo = $this->referencesJobsTwoRepository->find($referenceTwoID->id);

        $referenceTwoID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->find($referenceTwoID->id);

        if (empty($referencesJobsTwo)) {
            Flash::error('References Jobs Two not found');

            return redirect(route('referencesJobsTwos.index'));
        }

        $view = 'confirmation_independents.edit';
        $msj = 'References Jobs Two updated successfully.';
        if($referencesPersonalesTwo->name_job == ''){
            $view = 'confirmation_independents.create';
            $msj = 'References Jobs Two saved successfully.';
        }

        $referencesJobsTwo = $this->referencesJobsTwoRepository->update($request->all(), $referenceTwoID->id);

        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $confirmationIndependent = $this->confirmationIndependentRepository->find($confirmationIndependentID->id);

        $companiesID = DB::table('companies')->select('id')->where('user_id', '=', $id)->first();

        Flash::success($msj);
        if(!empty($companiesID)){
            $companies = $this->companiesRepository->find($companiesID->id);
            return view($view)->with('confirmationIndependent', $confirmationIndependent)->with('companies', $companies);
        }else{
            return view($view)->with('confirmationIndependent', $confirmationIndependent);
        }
    }

    /**
     * Remove the specified ReferencesJobsTwo from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $referencesJobsTwo = $this->referencesJobsTwoRepository->find($id);

        if (empty($referencesJobsTwo)) {
            Flash::error('References Jobs Two not found');

            return redirect(route('referencesJobsTwos.index'));
        }

        $this->referencesJobsTwoRepository->delete($id);

        Flash::success('References Jobs Two deleted successfully.');

        return redirect(route('referencesJobsTwos.index'));
    }
}
