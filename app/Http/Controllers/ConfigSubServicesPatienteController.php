<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConfigSubServicesPatienteRequest;
use App\Http\Requests\UpdateConfigSubServicesPatienteRequest;
use App\Repositories\ConfigSubServicesPatienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ConfigSubServicesPatienteController extends AppBaseController
{
    /** @var ConfigSubServicesPatienteRepository $configSubServicesPatienteRepository*/
    private $configSubServicesPatienteRepository;

    public function __construct(ConfigSubServicesPatienteRepository $configSubServicesPatienteRepo)
    {
        $this->configSubServicesPatienteRepository = $configSubServicesPatienteRepo;
    }

    /**
     * Display a listing of the ConfigSubServicesPatiente.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $configSubServicesPatientes = $this->configSubServicesPatienteRepository->all();

        return view('config_sub_services_patientes.index')
            ->with('configSubServicesPatientes', $configSubServicesPatientes);
    }

    /**
     * Show the form for creating a new ConfigSubServicesPatiente.
     *
     * @return Response
     */
    public function create()
    {
        return view('config_sub_services_patientes.create');
    }

    /**
     * Store a newly created ConfigSubServicesPatiente in storage.
     *
     * @param CreateConfigSubServicesPatienteRequest $request
     *
     * @return Response
     */
    public function store(CreateConfigSubServicesPatienteRequest $request)
    {
        $input = $request->all();

        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->create($input);

        Flash::success('Config Sub Services Patiente saved successfully.');

        return redirect(route('configSubServicesPatientes.index'));
    }

    /**
     * Display the specified ConfigSubServicesPatiente.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->find($id);

        if (empty($configSubServicesPatiente)) {
            Flash::error('Config Sub Services Patiente not found');

            return redirect(route('configSubServicesPatientes.index'));
        }

        return view('config_sub_services_patientes.show')->with('configSubServicesPatiente', $configSubServicesPatiente);
    }

    /**
     * Show the form for editing the specified ConfigSubServicesPatiente.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->find($id);

        if (empty($configSubServicesPatiente)) {
            Flash::error('Config Sub Services Patiente not found');

            return redirect(route('configSubServicesPatientes.index'));
        }

        return view('config_sub_services_patientes.edit')->with('configSubServicesPatiente', $configSubServicesPatiente);
    }

    /**
     * Update the specified ConfigSubServicesPatiente in storage.
     *
     * @param int $id
     * @param UpdateConfigSubServicesPatienteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConfigSubServicesPatienteRequest $request)
    {
        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->find($id);

        if (empty($configSubServicesPatiente)) {
            Flash::error('Config Sub Services Patiente not found');

            return redirect(route('configSubServicesPatientes.index'));
        }

        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->update($request->all(), $id);

        Flash::success('Config Sub Services Patiente updated successfully.');

        return redirect(route('configSubServicesPatientes.index'));
    }

    /**
     * Remove the specified ConfigSubServicesPatiente from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $configSubServicesPatiente = $this->configSubServicesPatienteRepository->find($id);

        if (empty($configSubServicesPatiente)) {
            Flash::error('Config Sub Services Patiente not found');

            return redirect(route('configSubServicesPatientes.index'));
        }

        $this->configSubServicesPatienteRepository->delete($id);

        Flash::success('Config Sub Services Patiente deleted successfully.');

        return redirect(route('configSubServicesPatientes.index'));
    }
}
