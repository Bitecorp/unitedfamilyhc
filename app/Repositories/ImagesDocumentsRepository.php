<?php

namespace App\Repositories;

use App\Models\ImagesDocuments;
use App\Repositories\BaseRepository;

/**
 * Class ImagesDocumentsRepository
 * @package App\Repositories
 * @version March 3, 2022, 5:53 pm UTC
*/

class ImagesDocumentsRepository extends BaseRepository
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
        return ImagesDocuments::class;
    }
}
