<?php

namespace App\Repositories;

use App\Models\DataFile;
use App\Repositories\BaseRepository;

/**
 * Class DataFileRepository
 * @package App\Repositories
 * @version July 29, 2021, 8:42 am UTC
*/

class DataFileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'url',
        'path',
        'ext',
        'mime_type',
        'status'
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
        return DataFile::class;
    }
}