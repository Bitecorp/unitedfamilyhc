<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReferencesJobsRequest;
use App\Http\Requests\UpdateReferencesJobsRequest;
use App\Repositories\ReferencesJobsRepository;
use App\Repositories\ReferencesPersonalesTwoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;

class ReferencesJobsController extends AppBaseController
{
    /** @var  ReferencesJobsRepository */
    private $referencesJobsRepository;

    /** @var  ReferencesPersonalesTwoRepository */
    private $referencesPersonalesTwoRepository;

    public function __construct(
        ReferencesJobsRepository $referencesJobsRepo,
        ReferencesPersonalesTwoRepository $referencesPersonalesTwoRepo
    )
    {
        $this->referencesJobsRepository = $referencesJobsRepo;
        $this->referencesPersonalesTwoRepository = $referencesPersonalesTwoRepo;
    }

    /**
     * Display a listing of the ReferencesJobs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $referencesJobs = $this->referencesJobsRepository->paginate(10);

        return view('references_jobs.index')
            ->with('referencesJobs', $referencesJobs);
    }

    /**
     * Show the form for creating a new ReferencesJobs.
     *
     * @return Response
     */
    public function create()
    {
        return view('references_jobs.create');
    }

    /**
     * Store a newly created ReferencesJobs in storage.
     *
     * @param CreateReferencesJobsRequest $request
     *
     * @return Response
     */
    public function store(CreateReferencesJobsRequest $request)
    {
        $input = $request->all();

        $referencesJobs = $this->referencesJobsRepository->create($input);

        Flash::success('References Jobs saved successfully.');

        return redirect(route('referencesJobs.index'));
    }

    /**
     * Display the specified ReferencesJobs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $referencesJobs = $this->referencesJobsRepository->find($id);

        if (empty($referencesJobs)) {
            Flash::error('References Jobs not found');

            return redirect(route('referencesJobs.index'));
        }

        return view('references_jobs.show')->with('referencesJobs', $referencesJobs);
    }

    /**
     * Show the form for editing the specified ReferencesJobs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $referencesJobs = $this->referencesJobsRepository->find($id);

        if (empty($referencesJobs)) {
            Flash::error('References Jobs not found');

            return redirect(route('referencesJobs.index'));
        }

        return view('references_jobs.edit')->with('referencesJobs', $referencesJobs);
    }

    /**
     * Update the specified ReferencesJobs in storage.
     *
     * @param int $id
     * @param UpdateReferencesJobsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $referenceOneID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '1')->first();
        $referencesJobs = $this->referencesJobsRepository->find($referenceOneID->id);

        $referenceTwoID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->find($referenceTwoID->id);

        if (empty($referencesJobs)) {
            Flash::error('References Jobs not found');

            return redirect(route('referencesJobs.index'));
        }

        $view = 'references_jobs_twos.edit';
        $msj = 'References Jobs One updated successfully.';
        if($referencesPersonalesTwo->name_job == '' ){
            $view = 'references_jobs_twos.create';
            $msj = 'References Personales Two saved successfully.';
        }

        $referencesJobs = $this->referencesJobsRepository->update($request->all(), $referenceOneID->id);

        $referenceJobTwoID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referenceJobTwo = $this->referencesJobsRepository->find($referenceJobTwoID->id);

        Flash::success($msj);
        return view($view)->with('referenceJobTwo', $referenceJobTwo);
    }

    /**
     * Remove the specified ReferencesJobs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $referencesJobs = $this->referencesJobsRepository->find($id);

        if (empty($referencesJobs)) {
            Flash::error('References Jobs not found');

            return redirect(route('referencesJobs.index'));
        }

        $this->referencesJobsRepository->delete($id);

        Flash::success('References Jobs deleted successfully.');

        return redirect(route('referencesJobs.index'));
    }
}
