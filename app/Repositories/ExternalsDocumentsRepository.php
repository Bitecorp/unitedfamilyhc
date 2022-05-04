<?php

namespace App\Repositories;

use App\Models\ExternalsDocuments;
use App\Repositories\BaseRepository;

/**
 * Class ExternalsDocumentsRepository
 * @package App\Repositories
 * @version March 3, 2022, 5:53 pm UTC
*/

class ExternalsDocumentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'file'
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
        return ExternalsDocuments::class;
    }
}
