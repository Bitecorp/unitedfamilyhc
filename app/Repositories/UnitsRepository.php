<?php

namespace App\Repositories;

use App\Models\Units;
use App\Repositories\BaseRepository;

/**
 * Class UnitsRepository
 * @package App\Repositories
 * @version May 4, 2022, 7:55 pm UTC
*/

class UnitsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'time',
        'type_unidad'
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
        return Units::class;
    }
}
