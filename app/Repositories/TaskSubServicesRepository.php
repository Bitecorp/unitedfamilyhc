<?php

namespace App\Repositories;

use App\Models\TaskSubServices;
use App\Repositories\BaseRepository;

/**
 * Class TaskSubServicesRepository
 * @package App\Repositories
 * @version May 4, 2022, 7:55 pm UTC
*/

class TaskSubServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_task'
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
        return TaskSubServices::class;
    }
}
