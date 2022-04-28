<?php

namespace App\Repositories;

use App\Models\AlertDocumentsExpired;
use App\Repositories\BaseRepository;

/**
 * Class AlertDocumentsRepository
 * @package App\Repositories
 * @version April 7, 2022, 12:08 pm UTC
*/

class AlertDocumentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'document_user_file_id'
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
        return AlertDocumentsExpired::class;
    }
}
