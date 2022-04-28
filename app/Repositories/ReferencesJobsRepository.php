<?php

namespace App\Repositories;

use App\Models\ReferencesJobs;
use App\Repositories\BaseRepository;

/**
 * Class ReferencesJobsRepository
 * @package App\Repositories
 * @version February 8, 2022, 4:24 pm UTC
*/

class ReferencesJobsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'name_and_address',
        'position',
        'supervisor',
        'phone_supervisor',
        'dates_employed',
        'to_dates_employed',
        'reason_leaving'
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
        return ReferencesJobs::class;
    }
}
