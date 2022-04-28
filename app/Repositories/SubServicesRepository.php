<?php

namespace App\Repositories;

use App\Models\SubServices;
use App\Repositories\BaseRepository;

/**
 * Class SubServicesRepository
 * @package App\Repositories
 * @version April 19, 2022, 11:23 am UTC
*/

class SubServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'service_id',
        'name_sub_service',
        'price_sub_service',
        'config_validate'
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
        return SubServices::class;
    }
}
