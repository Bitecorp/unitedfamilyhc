<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Repositories\BankRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Bank;
use Flash;
use Response;

class BankController extends AppBaseController
{
    /** @var  BankRepository */
    private $bankRepository;

    public function __construct(BankRepository $bankRepo)
    {
        $this->bankRepository = $bankRepo;
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
        return view('banks.create');
    }

    /**
     * Store a newly created Bank in storage.
     *
     * @param CreateBankRequest $request
     *
     * @return Response
     */
    public function store(CreateBankRequest $request)
    {
        $input = $request->all();

        $bank = $this->bankRepository->create($input);

        Flash::success('Bank saved successfully.');

        return redirect(route('banks.index'));
    }

    /**
     * Display the specified Bank.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bank = $this->bankRepository->find($id);

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
    public function edit($id)
    {
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        return view('banks.edit')->with('bank', $bank);
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
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        $bank = $this->bankRepository->update($request->all(), $id);

        Flash::success('Bank updated successfully.');

        return redirect(route('banks.index'));
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
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error('Bank not found');

            return redirect(route('banks.index'));
        }

        $this->bankRepository->delete($id);

        Flash::success('Bank deleted successfully.');

        return redirect(route('banks.index'));
    }
}
