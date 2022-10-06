<?php

namespace App\Repositories;

use App\Models\ConnectionsExternals;
use App\Repositories\BaseRepository;

/**
 * Class ConnectionsExternalsRepository
 * @package App\Repositories
 * @version October 6, 2022, 4:54 pm UTC
*/

class ConnectionsExternalsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_connection',
        'server_connection',
        'port_connection',
        'user_connection',
        'password_connection'
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
        return ConnectionsExternals::class;
    }
}
