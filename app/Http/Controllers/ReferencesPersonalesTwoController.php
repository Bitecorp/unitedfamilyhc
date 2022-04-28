<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReferencesPersonalesTwoRequest;
use App\Http\Requests\UpdateReferencesPersonalesTwoRequest;
use App\Repositories\ReferencesPersonalesTwoRepository;
use App\Http\Requests\CreateReferencesJobsRequest;
use App\Http\Requests\UpdateReferencesJobsRequest;
use App\Repositories\ReferencesJobsRepository;
use App\Repositories\ConfirmationIndependentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;

class ReferencesPersonalesTwoController extends AppBaseController
{
    /** @var  ReferencesPersonalesTwoRepository */
    private $referencesPersonalesTwoRepository;

    /** @var  ReferencesJobsRepository */
    private $referencesJobsRepository;

    /** @var  ConfirmationIndependentRepository */
    private $confirmationIndependentRepository;

    public function __construct(
        ReferencesPersonalesTwoRepository $referencesPersonalesTwoRepo,
        ReferencesJobsRepository $referencesJobsRepo,
        ConfirmationIndependentRepository $confirmationIndependentRepo
    )
    {
        $this->referencesPersonalesTwoRepository = $referencesPersonalesTwoRepo;
        $this->referencesJobsRepository = $referencesJobsRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
    }

    /**
     * Display a listing of the ReferencesPersonalesTwo.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $referencesPersonalesTwos = $this->referencesPersonalesTwoRepository->paginate(10);

        return view('references_personales_twos.index')
            ->with('referencesPersonalesTwos', $referencesPersonalesTwos);
    }

    /**
     * Show the form for creating a new ReferencesPersonalesTwo.
     *
     * @return Response
     */
    public function create()
    {
        return view('references_personales_twos.create');
    }

    /**
     * Store a newly created ReferencesPersonalesTwo in storage.
     *
     * @param CreateReferencesPersonalesTwoRequest $request
     *
     * @return Response
     */
    public function store(CreateReferencesPersonalesTwoRequest $request)
    {
        $input = $request->all();

        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->create($input);

        Flash::success('References Personales Two saved successfully.');

        return redirect(route('referencesPersonalesTwos.index'));
    }

    /**
     * Display the specified ReferencesPersonalesTwo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->find($id);

        if (empty($referencesPersonalesTwo)) {
            Flash::error('References Personales Two not found');

            return redirect(route('referencesPersonalesTwos.index'));
        }

        return view('references_personales_twos.show')->with('referencesPersonalesTwo', $referencesPersonalesTwo);
    }

    /**
     * Show the form for editing the specified ReferencesPersonalesTwo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->find($id);

        if (empty($referencesPersonalesTwo)) {
            Flash::error('References Personales Two not found');

            return redirect(route('referencesPersonalesTwos.index'));
        }

        return view('references_personales_twos.edit')->with('referencesPersonalesTwo', $referencesPersonalesTwo);
    }

    /**
     * Update the specified ReferencesPersonalesTwo in storage.
     *
     * @param int $id
     * @param UpdateReferencesPersonalesTwoRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $referenceTwoID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->find($referenceTwoID->id);

        if (empty($referencesPersonalesTwo)) {
            Flash::error('References Personales Two not found');

            return redirect(route('referencesPersonalesTwos.index'));
        }

        $view = 'references_jobs.edit';
        $msj = 'References Personales Two updated successfully.';
        if($referencesPersonalesTwo->name_job == '' ){
            $view = 'references_jobs.create';
            $msj = 'References Personales Two saved successfully.';
        }

        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->update($request->all(), $referenceTwoID->id);

        $referenceJobID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referenceJob = $this->referencesJobsRepository->find($referenceJobID->id);

        Flash::success($msj);
        return view($view)->with('referenceJob', $referenceJob);
    }

    /**
     * Remove the specified ReferencesPersonalesTwo from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $referencesPersonalesTwo = $this->referencesPersonalesTwoRepository->find($id);

        if (empty($referencesPersonalesTwo)) {
            Flash::error('References Personales Two not found');

            return redirect(route('referencesPersonalesTwos.index'));
        }

        $this->referencesPersonalesTwoRepository->delete($id);

        Flash::success('References Personales Two deleted successfully.');

        return redirect(route('referencesPersonalesTwos.index'));
    }
}
