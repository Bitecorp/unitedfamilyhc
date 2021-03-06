<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaritalStatusRequest;
use App\Http\Requests\UpdateMaritalStatusRequest;
use App\Repositories\MaritalStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\MaritalStatus;
use App\Models\User;
use Flash;
use Response;

class MaritalStatusController extends AppBaseController
{
    /** @var  MaritalStatusRepository */
    private $maritalStatusRepository;

    public function __construct(MaritalStatusRepository $maritalStatusRepo)
    {
        $this->maritalStatusRepository = $maritalStatusRepo;
    }

    /**
     * Display a listing of the MaritalStatus.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $maritalStatuses = MaritalStatus::all();

        return view('marital_statuses.index')
            ->with('maritalStatuses', $maritalStatuses);
    }

    /**
     * Show the form for creating a new MaritalStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('marital_statuses.create');
    }

    /**
     * Store a newly created MaritalStatus in storage.
     *
     * @param CreateMaritalStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateMaritalStatusRequest $request)
    {
        $input = $request->all();

        $maritalStatus = $this->maritalStatusRepository->create($input);

        Flash::success('Marital Status saved successfully.');

        return redirect(route('maritalStatuses.index'));
    }

    /**
     * Display the specified MaritalStatus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $maritalStatus = $this->maritalStatusRepository->find($id);

        if (empty($maritalStatus)) {
            Flash::error('Marital Status not found');

            return redirect(route('maritalStatuses.index'));
        }

        return view('marital_statuses.show')->with('maritalStatus', $maritalStatus);
    }

    /**
     * Show the form for editing the specified MaritalStatus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $maritalStatus = $this->maritalStatusRepository->find($id);

        if (empty($maritalStatus)) {
            Flash::error('Marital Status not found');

            return redirect(route('maritalStatuses.index'));
        }

        return view('marital_statuses.edit')->with('maritalStatus', $maritalStatus);
    }

    /**
     * Update the specified MaritalStatus in storage.
     *
     * @param int $id
     * @param UpdateMaritalStatusRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $maritalStatus = $this->maritalStatusRepository->find($id);

        if (empty($maritalStatus)) {
            Flash::error('Marital Status not found');

            return redirect(route('maritalStatuses.index'));
        }

        $maritalStatus = $this->maritalStatusRepository->update($request->all(), $id);

        Flash::success('Marital Status updated successfully.');

        return redirect(route('maritalStatuses.index'));
    }

    /**
     * Remove the specified MaritalStatus from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $maritalStatus = $this->maritalStatusRepository->find($id);

        if (empty($maritalStatus)) {
            Flash::error('Marital Status not found');

            return redirect(route('maritalStatuses.index'));
        }

        $maritalStatuA = User::where('marital_status', $id)->get();

        if(!empty($maritalStatuA) && isset($maritalStatuA) && count($maritalStatuA) >= 1){
            Flash::error('you cannot delete this marital status because it is assigned to one or more users');

            return redirect(route('maritalStatuses.index'));
        }

        $this->maritalStatusRepository->delete($id);

        Flash::success('Marital Status deleted successfully.');

        return redirect(route('maritalStatuses.index'));
    }
}
