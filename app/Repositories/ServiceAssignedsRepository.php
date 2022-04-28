<?php

namespace App\Repositories;

use App\Models\ServiceAssigneds;
use App\Repositories\BaseRepository;

/**
 * Class ServiceAssignedsRepository
 * @package App\Repositories
 * @version February 11, 2022, 7:38 am UTC
*/

class ServiceAssignedsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'services'
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
        return ServiceAssigneds::class;
    }
}
