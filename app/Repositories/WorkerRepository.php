<?php

namespace App\Repositories;

use App\Models\Worker;
use App\Repositories\BaseRepository;

/**
 * Class WorkerRepository
 * @package App\Repositories
 * @version January 20, 2022, 11:02 am UTC
*/

class WorkerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'mi',
        'street_addres',
        'apartment_unit',
        'city',
        'state',
        'zip_code',
        'home_phone',
        'alternate_phone',
        'ssn',
        'birth_date',
        'marital_status',
        'email',
        'email_verified_at',
        'password',
        'role_id',
        'statu_id',
        'remember_token',
        'companie_agent',
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
        return Worker::class;
    }
}
