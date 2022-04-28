<?php

namespace App\Repositories;

use App\Models\MaritalStatus;
use App\Repositories\BaseRepository;

/**
 * Class MaritalStatusRepository
 * @package App\Repositories
 * @version February 7, 2022, 3:37 am UTC
*/

class MaritalStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_marital_status'
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
        return MaritalStatus::class;
    }
}
