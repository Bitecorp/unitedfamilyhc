<?php

namespace App\Repositories;

use App\Models\ConfigSubServicesPatiente;
use App\Repositories\BaseRepository;

/**
 * Class ConfigSubServicesPatienteRepository
 * @package App\Repositories
 * @version June 6, 2022, 11:03 pm UTC
*/

class ConfigSubServicesPatienteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'salary_service_assigned_id',
        'agent_id',
        'code_patiente',
        'approved_units',
        'date_expedition',
        'date_expired'
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
        return ConfigSubServicesPatiente::class;
    }
}
