<?php

namespace App\Repositories;

use App\Models\Statu;
use App\Repositories\BaseRepository;

/**
 * Class StatuRepository
 * @package App\Repositories
 * @version January 20, 2022, 4:14 am UTC
*/

class StatuRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_status'
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
        return Statu::class;
    }
}
