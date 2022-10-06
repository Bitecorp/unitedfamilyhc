<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConnectionsExternalsRequest;
use App\Http\Requests\UpdateConnectionsExternalsRequest;
use App\Repositories\ConnectionsExternalsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ConnectionsExternalsController extends AppBaseController
{
    /** @var ConnectionsExternalsRepository $connectionsExternalsRepository*/
    private $connectionsExternalsRepository;

    public function __construct(ConnectionsExternalsRepository $connectionsExternalsRepo)
    {
        $this->connectionsExternalsRepository = $connectionsExternalsRepo;
    }

    /**
     * Display a listing of the ConnectionsExternals.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $connectionsExternals = $this->connectionsExternalsRepository->all();

        return view('connections_externals.index')
            ->with('connectionsExternals', $connectionsExternals);
    }

    /**
     * Show the form for creating a new ConnectionsExternals.
     *
     * @return Response
     */
    public function create()
    {
        return view('connections_externals.create');
    }

    /**
     * Store a newly created ConnectionsExternals in storage.
     *
     * @param CreateConnectionsExternalsRequest $request
     *
     * @return Response
     */
    public function store(CreateConnectionsExternalsRequest $request)
    {
        $input = $request->all();

        $connectionsExternals = $this->connectionsExternalsRepository->create($input);

        Flash::success('Connections Externals saved successfully.');

        return redirect(route('connectionsExternals.index'));
    }

    /**
     * Display the specified ConnectionsExternals.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $connectionsExternals = $this->connectionsExternalsRepository->find($id);

        if (empty($connectionsExternals)) {
            Flash::error('Connections Externals not found');

            return redirect(route('connectionsExternals.index'));
        }

        return view('connections_externals.show')->with('connectionsExternals', $connectionsExternals);
    }

    /**
     * Show the form for editing the specified ConnectionsExternals.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $connectionsExternals = $this->connectionsExternalsRepository->find($id);

        if (empty($connectionsExternals)) {
            Flash::error('Connections Externals not found');

            return redirect(route('connectionsExternals.index'));
        }

        return view('connections_externals.edit')->with('connectionsExternals', $connectionsExternals);
    }

    /**
     * Update the specified ConnectionsExternals in storage.
     *
     * @param int $id
     * @param UpdateConnectionsExternalsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConnectionsExternalsRequest $request)
    {
        $connectionsExternals = $this->connectionsExternalsRepository->find($id);

        if (empty($connectionsExternals)) {
            Flash::error('Connections Externals not found');

            return redirect(route('connectionsExternals.index'));
        }

        $connectionsExternals = $this->connectionsExternalsRepository->update($request->all(), $id);

        Flash::success('Connections Externals updated successfully.');

        return redirect(route('connectionsExternals.index'));
    }

    /**
     * Remove the specified ConnectionsExternals from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $connectionsExternals = $this->connectionsExternalsRepository->find($id);

        if (empty($connectionsExternals)) {
            Flash::error('Connections Externals not found');

            return redirect(route('connectionsExternals.index'));
        }

        $this->connectionsExternalsRepository->delete($id);

        Flash::success('Connections Externals deleted successfully.');

        return redirect(route('connectionsExternals.index'));
    }
}
