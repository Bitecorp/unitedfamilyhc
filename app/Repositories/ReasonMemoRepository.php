<?php

namespace App\Repositories;

use App\Models\ReasonMemo;
use App\Repositories\BaseRepository;

/**
 * Class ReasonMemoRepository
 * @package App\Repositories
 * @version Dicember 01, 2022, 4:14 am UTC
*/

class ReasonMemoRepository extends BaseRepository
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
        return ReasonMemo::class;
    }
}
