<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Repositories\InsuranceRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\InsuranceAssigneds;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Illuminate\Support\Collection;

class InsuranceController extends AppBaseController
{
    /** @var  InsuranceRepository */
    private $insuranceRepository;

    public function __construct(InsuranceRepository $insuranceRepo)
    {
        $this->insuranceRepository = $insuranceRepo;
    }

    /**
     * Display a listing of the Insurance.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $insurances = $this->insuranceRepository->paginate(10);

        return view('insurances.index')
            ->with('insurances', $insurances);
    }

    /**
     * Show the form for creating a new Insurance.
     *
     * @return Response
     */
    public function create()
    {
        $docs = DB::table('type_docs')->select('id', 'name_doc')->get();

        return view('insurances.create')->with('docs', $docs);
    }

    /**
     * Store a newly created Insurance in storage.
     *
     * @param CreateInsuranceRequest $request
     *
     * @return Response
     */
    public function store(CreateInsuranceRequest $request)
    {
        $input = $request->all();
        $input['documents'] = json_encode($input['documents']);
        $insurance = $this->insuranceRepository->create($input);

        Flash::success('Insurance saved successfully.');

        return redirect(route('insurances.index'));
    }

    /**
     * Display the specified Insurance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $insurance = $this->insuranceRepository->find($id);


        if (empty($insurance)) {
            Flash::error('Insurance not found');

            return redirect(route('insurances.index'));
        }

        return view('insurances.show')->with('insurance', $insurance);
    }

    /**
     * Show the form for editing the specified Insurance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $insurance = $this->insuranceRepository->find($id);

        if (empty($insurance)) {
            Flash::error('Insurance not found');

            return redirect(route('insurances.index'));
        }

        $docs = DB::table('type_docs')->select('id', 'name_doc')->get();

        $collections = collect(json_decode($insurance->documents));

        $data = [];

        foreach($collections as $collection){
            array_push($data, DB::table('type_docs')->select('id', 'name_doc')->where('id', $collection)->first());
        }

        $docDist = DB::table('type_docs')->select('id', 'name_doc')->get(); /* unset($flowers[1]); */

        foreach($collections as $collection){
            foreach($docs as $key => $doc){
                if($doc->id == $collection){
                    unset($docDist[$key]);
                }
            }
        }

        return view('insurances.edit')->with('insurance', $insurance)->with('docs', $docs)->with('collection', collect($data))->with('docDist', collect($docDist));
    }

    /**
     * Update the specified Insurance in storage.
     *
     * @param int $id
     * @param UpdateInsuranceRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $insurance = $this->insuranceRepository->find($id);

        if (empty($insurance)) {
            Flash::error('Insurance not found');

            return redirect(route('insurances.index'));
        }

        $input = $request->all();

        $input['documents'] = json_encode($input['documents']);

        $insurance = $this->insuranceRepository->update($input, $id);

        Flash::success('Insurance updated successfully.');

        return redirect(route('insurances.index'));
    }

    /**
     * Remove the specified Insurance from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $insurance = $this->insuranceRepository->find($id);

        if (empty($insurance)) {
            Flash::error('Insurance not found');

            return redirect(route('insurances.index'));
        }

        $this->insuranceRepository->delete($id);

        Flash::success('Insurance deleted successfully.');

        return redirect(route('insurances.index'));
    }
}
