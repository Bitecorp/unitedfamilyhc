<?php

namespace App\Repositories;

use App\Models\documentsEditors;
use App\Repositories\BaseRepository;

/**
 * Class documentsEditorsRepository
 * @package App\Repositories
 * @version March 2, 2022, 9:24 pm UTC
*/

class documentsEditorsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_document_editor',
        'content',
        'service_id'
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
        return documentsEditors::class;
    }
}
