<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReferencesPersonalesRequest;
use App\Http\Requests\UpdateReferencesPersonalesRequest;
use App\Repositories\ReferencesPersonalesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;

class ReferencesPersonalesController extends AppBaseController
{
    /** @var  ReferencesPersonalesRepository */
    private $referencesPersonalesRepository;

    public function __construct(ReferencesPersonalesRepository $referencesPersonalesRepo)
    {
        $this->referencesPersonalesRepository = $referencesPersonalesRepo;
    }

    /**
     * Display a listing of the ReferencesPersonales.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $referencesPersonales = $this->referencesPersonalesRepository->paginate(10);

        return view('references_personales.index')
            ->with('referencesPersonales', $referencesPersonales);
    }

    /**
     * Show the form for creating a new ReferencesPersonales.
     *
     * @return Response
     */
    public function create()
    {
        return view('references_personales.create');
    }

    /**
     * Store a newly created ReferencesPersonales in storage.
     *
     * @param CreateReferencesPersonalesRequest $request
     *
     * @return Response
     */
    public function store(CreateReferencesPersonalesRequest $request)
    {
        $input = $request->all();

        $referencesPersonales = $this->referencesPersonalesRepository->create($input);

        Flash::success('References Personales saved successfully.');

        return redirect(route('referencesPersonales.index'));
    }

    /**
     * Display the specified ReferencesPersonales.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $referencesPersonales = $this->referencesPersonalesRepository->find($id);

        if (empty($referencesPersonales)) {
            Flash::error('References Personales not found');

            return redirect(route('referencesPersonales.index'));
        }

        return view('references_personales.show')->with('referencesPersonales', $referencesPersonales);
    }

    /**
     * Show the form for editing the specified ReferencesPersonales.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $referencesPersonales = $this->referencesPersonalesRepository->find($id);

        if (empty($referencesPersonales)) {
            Flash::error('References Personales not found');

            return redirect(route('referencesPersonales.index'));
        }

        return view('references_personales.edit')->with('referencesPersonales', $referencesPersonales);
    }

    /**
     * Update the specified ReferencesPersonales in storage.
     *
     * @param int $id
     * @param UpdateReferencesPersonalesRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $referenceOneID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '1')->first();
        $referencesPersonales = $this->referencesPersonalesRepository->find($referenceOneID->id);

        if (empty($referencesPersonales)) {
            Flash::error('References Personales not found');

            return redirect(route('referencesPersonales.index'));
        }

        $view = 'references_personales_twos.edit';
        $msj = 'References Personales One updated successfully.';
        if($referencesPersonales->name_job == ''){
            $view = 'references_personales_twos.create';
            $msj = 'References Personales One saved successfully.';
        }


        $referencesPersonales = $this->referencesPersonalesRepository->update($request->all(), $referenceOneID->id);

        $referenceTwoID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referenceTwo = $this->referencesPersonalesRepository->find($referenceTwoID->id);

        Flash::success($msj);
        return view($view)->with('referenceTwo', $referenceTwo);
    }

    /**
     * Remove the specified ReferencesPersonales from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $referencesPersonales = $this->referencesPersonalesRepository->find($id);

        if (empty($referencesPersonales)) {
            Flash::error('References Personales not found');

            return redirect(route('referencesPersonales.index'));
        }

        $this->referencesPersonalesRepository->delete($id);

        Flash::success('References Personales deleted successfully.');

        return redirect(route('referencesPersonales.index'));
    }
}
