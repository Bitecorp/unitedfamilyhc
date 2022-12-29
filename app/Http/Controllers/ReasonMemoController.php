<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReasonMemoRequest;
use App\Http\Requests\UpdateReasonMemoRequest;
use App\Repositories\ReasonMemoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\ReasonMemo;
use App\Models\ReasonMemoForPai;
use Flash;
use Response;

class ReasonMemoController extends AppBaseController
{
    /** @var  ReasonMemoRepository */
    private $reasonMemoRepository;

    public function __construct(ReasonMemoRepository $reasonMemoRepo)
    {
        $this->reasonMemoRepository = $reasonMemoRepo;
    }

    /**
     * Display a listing of the ReasonMemo.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $reasonMemos = ReasonMemo::all();

        return view('reasons_memos.index')
            ->with('reasonMemos', $reasonMemos);
    }

    /**
     * Show the form for creating a new ReasonMemo.
     *
     * @return Response
     */
    public function create()
    {
        return view('reasons_memos.create');
    }

    /**
     * Store a newly created ReasonMemo in storage.
     *
     * @param CreateReasonMemoRequest $request
     *
     * @return Response
     */
    public function store(CreateReasonMemoRequest $request)
    {
        $input = $request->all();

        $reasonMemo = $this->reasonMemoRepository->create($input);

        Flash::success('Reason Memo saved successfully.');

        return redirect(route('reasonsMemos.index'));
    }

    /**
     * Display the specified ReasonMemo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reasonMemo = $this->reasonMemoRepository->find($id);

        if (empty($reasonMemo)) {
            Flash::error('Reason Memo not found');

            return redirect(route('reasonsMemos.index'));
        }

        return view('reasons_memos.show')->with('reasonMemo', $reasonMemo);
    }

    /**
     * Show the form for editing the specified ReasonMemo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reasonMemo = $this->reasonMemoRepository->find($id);

        if (empty($reasonMemo)) {
            Flash::error('Reason Memo not found');

            return redirect(route('reasonsMemos.index'));
        }

        return view('reasons_memos.edit')->with('reasonMemo', $reasonMemo);
    }

    /**
     * Update the specified ReasonMemo in storage.
     *
     * @param int $id
     * @param UpdateReasonMemoRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $reasonMemo = $this->reasonMemoRepository->find($id);

        if (empty($reasonMemo)) {
            Flash::error('Reason Memo not found');

            return redirect(route('reasonsMemos.index'));
        }

        $reasonMemo = $this->reasonMemoRepository->update($request->all(), $id);

        Flash::success('Reason Memo updated successfully.');

        return redirect(route('reasonsMemos.index'));
    }

    /**
     * Remove the specified ReasonMemo from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reasonMemo = $this->reasonMemoRepository->find($id);

        if (empty($reasonMemo)) {
            Flash::error('Reason Memo not found');

            return redirect(route('reasonsMemos.index'));
        }

        $this->reasonMemoRepository->delete($id);

        Flash::success('Reason Memo deleted successfully.');

        return redirect(route('reasonsMemos.index'));
    }

    public function addMemoForPai(Request $request){
        return [
            'data' => [],
            'msj' => "data encontrada",
            'success' => true
        ];

        //return view('reasons_memos.show')->with('reasonMemo', $reasonMemo);
    }

    public function addMemoForPaiView($idW, $idP, $idS, $idSS, Request $request){
        $reasonMemos = ReasonMemo::all();

        $decode = explode(",", base64_decode($request->all()['token']));
        $filters = [
            'worker_id' => $idW,
            'patiente_id' => $idP,
            'service_id' => $idS,
            'sub_service_id' => $idSS,
            'amount_base' => number_format((float)(floatval($decode[2]) - 0.01), 2, '.', '')
        ];

        $resonMemosForPai = ReasonMemoForPai::where($filters)->where('from', '>=',  $decode[0] . ' 00:00:01')->where('to', '>=',  $decode[1] . ' 23:59:59')->first();

        return view('reasons_memos.addMemoForPaiView')->with('reasonMemos', $reasonMemos)->with('resonMemosForPai', $resonMemosForPai ? $resonMemosForPai : null);
    }

    public function addMemoForPaiStore(Request $request){
        $input = $request->all();
        $filters = [
            'worker_id' => $input['worker_id'],
            'patiente_id' => $input['patiente_id'],
            'service_id' => $input['service_id'],
            'sub_service_id' => $input['sub_service_id'],
            'amount_base' => number_format((float)floatval($input['amount_base']), 2, '.', '')
        ];

        $resonMemosForPai = ReasonMemoForPai::where($filters)->where('from', '>=',  $input['from'])->where('to', '>=',  $input['to'])->first();

        $flight = isset($resonMemosForPai) ? ReasonMemoForPai::find($resonMemosForPai->id) : new ReasonMemoForPai;
        foreach($input AS $k => $v){
            if($k != '_token' &&
                $k != 'worker' &&
                $k != 'patiente' &&
                $k != 'service' &&
                $k != 'sub_service' &&
                $k != 'desde' &&
                $k != 'hasta' &&
                $k != 'reason_id' &&
                $k != 'mont_memo'
            ){
                $flight->$k = $v;
            }

            if($k == 'reason_id'){
                $flight->reasons_id = json_encode($v);
            }

            if($k == 'mont_memo'){
                $flight->monts_memo = json_encode($v);
            }
        }

        if(!isset($resonMemosForPai)){
            $flight->created_at = now();
        }        
        $flight->updated_at = now();
        
        $flight->save();
        return redirect(route('manageBillAndPay'));
    }
    
}
