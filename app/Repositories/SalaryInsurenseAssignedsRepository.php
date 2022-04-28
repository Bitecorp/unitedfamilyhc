<?php

namespace App\Repositories;

use App\Models\SalaryInsurenseAssigneds;
use App\Repositories\BaseRepository;

/**
 * Class SalaryInsurenseAssignedsRepository
 * @package App\Repositories
 * @version March 9, 2022, 10:11 pm UTC
*/

class SalaryInsurenseAssignedsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'insurance_id',
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
        return SalaryInsurenseAssigneds::class;
    }
}
