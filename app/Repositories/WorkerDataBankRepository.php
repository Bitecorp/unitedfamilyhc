<?php

namespace App\Repositories;

use App\Models\WorkerDataBank;
use App\Repositories\BaseRepository;

/**
 * Class BankRepository
 * @package App\Repositories
 * @version Dicember 01, 2022, 4:14 am UTC
*/

class WorkerDataBankRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_bank'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WorkerDataBank::class;
    }
}
