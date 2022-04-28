<?php

namespace App\Repositories;

use App\Models\Companies;
use App\Repositories\BaseRepository;

/**
 * Class CompaniesRepository
 * @package App\Repositories
 * @version February 9, 2022, 9:32 pm UTC
*/

class CompaniesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'street_addres',
        'apartment_unit',
        'city',
        'state',
        'zip_code',
        'home_phone',
        'alternate_phone',
        'ssn',
        'email'
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
        return Companies::class;
    }
}
