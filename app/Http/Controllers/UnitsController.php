<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Repositories\UnitsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class UnitsController extends AppBaseController
{
    /** @var UnitsRepository $unitsRepository*/
    private $unitsRepository;

    public function __construct(UnitsRepository $unitsRepo)
    {
        $this->unitsRepository = $unitsRepo;
    }

    /**
     * Display a listing of the Units.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $units = $this->unitsRepository->all();

        return view('units.index')
            ->with('units', $units);
    }

    /**
     * Show the form for creating a new Units.
     *
     * @return Response
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created Units in storage.
     *
     * @param CreateUnitsRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if(isset($input['type_unidad'])){
            $input['type_unidad'] = true;
        }else{
            $input['type_unidad'] = false;
        }

        $units = $this->unitsRepository->create($input);

        Flash::success('Units saved successfully.');

        return redirect(route('units.index'));
    }

    /**
     * Display the specified Units.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        return view('units.show')->with('units', $units);
    }

    /**
     * Show the form for editing the specified Units.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        return view('units.edit')->with('units', $units);
    }

    /**
     * Update the specified Units in storage.
     *
     * @param int $id
     * @param UpdateUnitsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        $input = $request->all();
        if(isset($input['type_unidad'])){
            $input['type_unidad'] = true;
        }else{
            $input['type_unidad'] = false;
        }

        $units = $this->unitsRepository->update($input, $id);

        Flash::success('Units updated successfully.');

        return redirect(route('units.index'));
    }

    /**
     * Remove the specified Units from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        $this->unitsRepository->delete($id);

        Flash::success('Units deleted successfully.');

        return redirect(route('units.index'));
    }
}
