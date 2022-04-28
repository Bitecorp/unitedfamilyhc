<?php

namespace App\Repositories;

use App\Models\JobInformation;
use App\Repositories\BaseRepository;

/**
 * Class JobInformationRepository
 * @package App\Repositories
 * @version January 20, 2022, 1:21 pm UTC
*/

class JobInformationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'title',
        'supervisor',
        'work_name_location',
        'work_phone',
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
        return JobInformation::class;
    }
}
