<?php

namespace App\Repositories;

use App\Models\ContactEmergency;
use App\Repositories\BaseRepository;

/**
 * Class ContactEmergencyRepository
 * @package App\Repositories
 * @version January 20, 2022, 12:59 pm UTC
*/

class ContactEmergencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'first_name',
        'last_name',
        'mi',
        'street_addres',
        'apartment_unit',
        'city',
        'state',
        'zip_code',
        'home_phone',
        'alternate_phone'
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
        return ContactEmergency::class;
    }
}
