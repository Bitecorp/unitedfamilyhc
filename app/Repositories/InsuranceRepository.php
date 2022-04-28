<?php

namespace App\Repositories;

use App\Models\Insurance;
use App\Repositories\BaseRepository;

/**
 * Class InsuranceRepository
 * @package App\Repositories
 * @version February 9, 2022, 2:28 pm UTC
*/

class InsuranceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_insurance',
        'documents'
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
        return Insurance::class;
    }
}
