<?php

namespace App\Repositories;

use App\Models\DocumentUserFiles;
use App\Repositories\BaseRepository;

/**
 * Class DocumentUserFilesRepository
 * @package App\Repositories
 * @version February 11, 2022, 8:00 pm UTC
*/

class DocumentUserFilesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'document_id',
        'date_expedition',
        'date_expired',
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
        return DocumentUserFiles::class;
    }
}
