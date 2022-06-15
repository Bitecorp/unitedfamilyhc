<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTitleJobsRequest;
use App\Http\Requests\UpdateTitleJobsRequest;
use App\Repositories\TitleJobsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\TitleJobs;
use App\Models\JobInformation;
use Flash;
use Response;

class TitleJobsController extends AppBaseController
{
    /** @var  TitleJobsRepository */
    private $titleJobsRepository;

    public function __construct(TitleJobsRepository $titleJobsRepo)
    {
        $this->titleJobsRepository = $titleJobsRepo;
    }

    /**
     * Display a listing of the TitleJobs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titleJobs = TitleJobs::all();

        return view('title_jobs.index')
            ->with('titleJobs', $titleJobs);
    }

    /**
     * Show the form for creating a new TitleJobs.
     *
     * @return Response
     */
    public function create()
    {
        return view('title_jobs.create');
    }

    /**
     * Store a newly created TitleJobs in storage.
     *
     * @param CreateTitleJobsRequest $request
     *
     * @return Response
     */
    public function store(CreateTitleJobsRequest $request)
    {
        $input = $request->all();

        $titleJobs = $this->titleJobsRepository->create($input);

        Flash::success('Title Jobs saved successfully.');

        return redirect(route('titleJobs.index'));
    }

    /**
     * Display the specified TitleJobs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $titleJobs = $this->titleJobsRepository->find($id);

        if (empty($titleJobs)) {
            Flash::error('Title Jobs not found');

            return redirect(route('titleJobs.index'));
        }

        return view('title_jobs.show')->with('titleJobs', $titleJobs);
    }

    /**
     * Show the form for editing the specified TitleJobs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $titleJobs = $this->titleJobsRepository->find($id);

        if (empty($titleJobs)) {
            Flash::error('Title Jobs not found');

            return redirect(route('titleJobs.index'));
        }

        return view('title_jobs.edit')->with('titleJobs', $titleJobs);
    }

    /**
     * Update the specified TitleJobs in storage.
     *
     * @param int $id
     * @param UpdateTitleJobsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $titleJobs = $this->titleJobsRepository->find($id);

        if (empty($titleJobs)) {
            Flash::error('Title Jobs not found');

            return redirect(route('titleJobs.index'));
        }

        $titleJobs = $this->titleJobsRepository->update($request->all(), $id);

        Flash::success('Title Jobs updated successfully.');

        return redirect(route('titleJobs.index'));
    }

    /**
     * Remove the specified TitleJobs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $titleJobs = $this->titleJobsRepository->find($id);

        if (empty($titleJobs)) {
            Flash::error('Title Jobs not found');

            return redirect(route('titleJobs.index'));
        }

        $titleJobsA = JobInformation::where('title', $titleJobs->id)->get();

        if(!empty($titleJobsA) && isset($titleJobsA) && count($titleJobsA) >= 1){
            Flash::error('you cannot delete this job because it is assigned to one or more other users.');

            return redirect(route('titleJobs.index'));
        }

        $this->titleJobsRepository->delete($id);

        Flash::success('Title Jobs deleted successfully.');

        return redirect(route('titleJobs.index'));
    }
}
