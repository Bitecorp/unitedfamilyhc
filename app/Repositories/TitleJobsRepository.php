<?php

namespace App\Repositories;

use App\Models\TitleJobs;
use App\Repositories\BaseRepository;

/**
 * Class TitleJobsRepository
 * @package App\Repositories
 * @version February 8, 2022, 4:26 am UTC
*/

class TitleJobsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_job'
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
        return TitleJobs::class;
    }
}
