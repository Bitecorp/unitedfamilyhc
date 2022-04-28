<?php

namespace App\Repositories;

use App\Models\Education;
use App\Repositories\BaseRepository;

/**
 * Class EducationRepository
 * @package App\Repositories
 * @version January 20, 2022, 1:33 pm UTC
*/

class EducationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'high_school',
        'college_university'
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
        return Education::class;
    }
}
