<?php

namespace App\Repositories;

use App\Models\TypeDoc;
use App\Repositories\BaseRepository;

/**
 * Class TypeDocRepository
 * @package App\Repositories
 * @version February 9, 2022, 2:08 pm UTC
*/

class TypeDocRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_doc',
        'service_id',
        'role_id'
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
        return TypeDoc::class;
    }
}
