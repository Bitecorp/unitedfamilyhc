<?php

namespace App\Repositories;

use App\Models\InsuranceAssigneds;
use App\Repositories\BaseRepository;

/**
 * Class InsuranceAssignedsRepository
 * @package App\Repositories
 * @version February 11, 2022, 7:38 am UTC
*/

class InsuranceAssignedsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'insurances'
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
        return InsuranceAssigneds::class;
    }
}
