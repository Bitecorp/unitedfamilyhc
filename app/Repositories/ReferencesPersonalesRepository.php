<?php

namespace App\Repositories;

use App\Models\ReferencesPersonales;
use App\Repositories\BaseRepository;

/**
 * Class ReferencesPersonalesRepository
 * @package App\Repositories
 * @version February 8, 2022, 4:23 pm UTC
*/

class ReferencesPersonalesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
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
        return ReferencesPersonales::class;
    }
}
