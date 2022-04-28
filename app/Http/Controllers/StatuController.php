<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatuRequest;
use App\Http\Requests\UpdateStatuRequest;
use App\Repositories\StatuRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Statu;
use Flash;
use Response;

class StatuController extends AppBaseController
{
    /** @var  StatuRepository */
    private $statuRepository;

    public function __construct(StatuRepository $statuRepo)
    {
        $this->statuRepository = $statuRepo;
    }

    /**
     * Display a listing of the Statu.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $status = Statu::all();

        return view('status.index')
            ->with('status', $status);
    }

    /**
     * Show the form for creating a new Statu.
     *
     * @return Response
     */
    public function create()
    {
        return view('status.create');
    }

    /**
     * Store a newly created Statu in storage.
     *
     * @param CreateStatuRequest $request
     *
     * @return Response
     */
    public function store(CreateStatuRequest $request)
    {
        $input = $request->all();

        $estate = $this->statuRepository->create($input);

        Flash::success('Statu saved successfully.');

        return redirect(route('status.index'));
    }

    /**
     * Display the specified Statu.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estate = $this->statuRepository->find($id);

        if (empty($estate)) {
            Flash::error('Statu not found');

            return redirect(route('status.index'));
        }

        return view('status.show')->with('estate', $estate);
    }

    /**
     * Show the form for editing the specified Statu.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estate = $this->statuRepository->find($id);

        if (empty($estate)) {
            Flash::error('Statu not found');

            return redirect(route('status.index'));
        }

        return view('status.edit')->with('estate', $estate);
    }

    /**
     * Update the specified Statu in storage.
     *
     * @param int $id
     * @param UpdateStatuRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $estate = $this->statuRepository->find($id);

        if (empty($estate)) {
            Flash::error('Statu not found');

            return redirect(route('status.index'));
        }

        $estate = $this->statuRepository->update($request->all(), $id);

        Flash::success('Statu updated successfully.');

        return redirect(route('status.index'));
    }

    /**
     * Remove the specified Statu from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estate = $this->statuRepository->find($id);

        if (empty($estate)) {
            Flash::error('Statu not found');

            return redirect(route('status.index'));
        }

        $this->statuRepository->delete($id);

        Flash::success('Statu deleted successfully.');

        return redirect(route('status.index'));
    }
}
