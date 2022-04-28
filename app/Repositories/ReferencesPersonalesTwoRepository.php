<?php

namespace App\Repositories;

use App\Models\ReferencesPersonalesTwo;
use App\Repositories\BaseRepository;

/**
 * Class ReferencesPersonalesTwoRepository
 * @package App\Repositories
 * @version February 8, 2022, 5:47 pm UTC
*/

class ReferencesPersonalesTwoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'reference_number',
        'name_job',
        'address',
        'phone',
        'ocupation',
        'time'
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
        return ReferencesPersonalesTwo::class;
    }
}
