<?php

namespace App\Repositories;

use App\Models\ReferencesJobsTwo;
use App\Repositories\BaseRepository;

/**
 * Class ReferencesJobsTwoRepository
 * @package App\Repositories
 * @version February 8, 2022, 5:48 pm UTC
*/

class ReferencesJobsTwoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'reference_number',
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
        return ReferencesJobsTwo::class;
    }
}
