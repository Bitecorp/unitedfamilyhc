<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Repositories\BankRepository;
use App\Repositories\WorkerDataBankRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\WorkerDataBank;
use Flash;
use Response;

class WorkerDataBankController extends AppBaseController
{
    /** @var  BankRepository */
    private $bankRepository;

    /** @var  WorkerDataBankRepository */
    private $workerDataBankRepository;

    public function __construct(
        BankRepository $bankRepo, 
        WorkerDataBankRepository $workerDataBankRepo
    )
    {
        $this->bankRepository = $bankRepo;
        $this->workerDataBankRepository = $workerDataBankRepo;
    }

    /**
     * Display a listing of the Bank.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $banks = Bank::all();

        return view('banks.index')
            ->with('banks', $banks);
    }

    /**
     * Show the form for creating a new Bank.
     *
     * @return Response
     */
    public function create()
    {
        $banks = Bank::all();
        return view('worker_data_bank.create')->with('banks', $banks);
    }

    /**
     * Store a newly created Bank in storage.
     *
     * @param CreateBankRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $bankAccount = WorkerDataBank::where('user_id', $input['user_id'])->where('bank_id', $input['bank_id'])->where('account', $input['account'])->first();
        if(isset($bankAccount) && !empty($bankAccount)){
            return redirect(route('workers.show', $input['user_id']) . '?banks');
        }else{
        
            $bank = $this->workerDataBankRepository->create($input);

            Flash::success('Bank Account saved successfully.');

            return redirect(route('workers.show', $input['user_id']) . '?banks');
        }
    }

    /**
     * Display the specified Bank.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($uidUser, $id)
    {
        $bank = $this->workerDataBankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        return view('banks.show')->with('bank', $bank);
    }

    /**
     * Show the form for editing the specified Bank.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($idUser, $id)
    {
        $bank = $this->workerDataBankRepository->find($id);
        $allBanks = Bank::all();

        return view('worker_data_bank.edit')->with('workerDataBank', $bank)->with('banks', $allBanks);
    }

    /**
     * Update the specified Bank in storage.
     *
     * @param int $id
     * @param UpdateBankRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $bank = $this->workerDataBankRepository->find($id);
        $input = $request->all();

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('workers.index') . '/' . $input['user_id'] . "?banks");
        }

        $bank = $this->workerDataBankRepository->update($input, $id);

        Flash::success('Bank Account updated successfully.');

        return redirect(route('workers.index') . '/' . $input['user_id'] . "?banks");
    }

    /**
     * Remove the specified Bank from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bank = $this->workerDataBankRepository->find($id);

        $this->workerDataBankRepository->delete($id);

        Flash::success('Bank Account deleted successfully.');

        return redirect(route('workers.index') . '/' . $bank->user_id . "?banks");
    }
}
