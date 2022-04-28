<?php

namespace App\Repositories;

use App\Models\ConfirmationIndependent;
use App\Repositories\BaseRepository;

/**
 * Class ConfirmationIndependentRepository
 * @package App\Repositories
 * @version January 20, 2022, 1:33 pm UTC
*/

class ConfirmationIndependentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'independent_contractor'
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
        return ConfirmationIndependent::class;
    }
}
