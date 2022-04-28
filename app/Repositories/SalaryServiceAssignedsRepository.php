<?php

namespace App\Repositories;

use App\Models\SalaryServiceAssigneds;
use App\Repositories\BaseRepository;

/**
 * Class SalaryServiceAssignedsRepository
 * @package App\Repositories
 * @version March 9, 2022, 10:11 pm UTC
*/

class SalaryServiceAssignedsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'service_id',
        'type_salary',
        'salary'
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
        return SalaryServiceAssigneds::class;
    }
}
