<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskSubServicesRequest;
use App\Http\Requests\UpdateTaskSubServicesRequest;
use App\Repositories\TaskSubServicesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TaskSubServicesController extends AppBaseController
{
    /** @var TaskSubServicesRepository $taskSubServicesRepository*/
    private $taskSubServicesRepository;

    public function __construct(TaskSubServicesRepository $taskSubServicesRepo)
    {
        $this->taskSubServicesRepository = $taskSubServicesRepo;
    }

    /**
     * Display a listing of the TaskSubServices.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $taskSubServices = $this->taskSubServicesRepository->all();

        return view('task_sub_services.index')
            ->with('taskSubServices', $taskSubServices);
    }

    /**
     * Show the form for creating a new TaskSubServices.
     *
     * @return Response
     */
    public function create()
    {
        return view('task_sub_services.create');
    }

    /**
     * Store a newly created TaskSubServices in storage.
     *
     * @param CreateTaskSubServicesRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskSubServicesRequest $request)
    {
        $input = $request->all();

        $taskSubServices = $this->taskSubServicesRepository->create($input);

        Flash::success('Task Sub Services saved successfully.');

        return redirect(route('taskSubServices.index'));
    }

    /**
     * Display the specified TaskSubServices.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $taskSubServices = $this->taskSubServicesRepository->find($id);

        if (empty($taskSubServices)) {
            Flash::error('Task Sub Services not found');

            return redirect(route('taskSubServices.index'));
        }

        return view('task_sub_services.show')->with('taskSubServices', $taskSubServices);
    }

    /**
     * Show the form for editing the specified TaskSubServices.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $taskSubServices = $this->taskSubServicesRepository->find($id);

        if (empty($taskSubServices)) {
            Flash::error('Task Sub Services not found');

            return redirect(route('taskSubServices.index'));
        }

        return view('task_sub_services.edit')->with('taskSubServices', $taskSubServices);
    }

    /**
     * Update the specified TaskSubServices in storage.
     *
     * @param int $id
     * @param UpdateTaskSubServicesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskSubServicesRequest $request)
    {
        $taskSubServices = $this->taskSubServicesRepository->find($id);

        if (empty($taskSubServices)) {
            Flash::error('Task Sub Services not found');

            return redirect(route('taskSubServices.index'));
        }

        $taskSubServices = $this->taskSubServicesRepository->update($request->all(), $id);

        Flash::success('Task Sub Services updated successfully.');

        return redirect(route('taskSubServices.index'));
    }

    /**
     * Remove the specified TaskSubServices from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $taskSubServices = $this->taskSubServicesRepository->find($id);

        if (empty($taskSubServices)) {
            Flash::error('Task Sub Services not found');

            return redirect(route('taskSubServices.index'));
        }

        $this->taskSubServicesRepository->delete($id);

        Flash::success('Task Sub Services deleted successfully.');

        return redirect(route('taskSubServices.index'));
    }
}
