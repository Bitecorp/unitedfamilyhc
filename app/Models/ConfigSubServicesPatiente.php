<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="ConfigSubServicesPatiente",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="salary_service_assigned_id",
 *          description="salary_service_assigned_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="agent_id",
 *          description="agent_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="code_patiente",
 *          description="code_patiente",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="approved_units",
 *          description="approved_units",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="date_expedition",
 *          description="date_expedition",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="date_expired",
 *          description="date_expired",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class ConfigSubServicesPatiente extends Model
{

    use HasFactory;

    public $table = 'config_sub_services_patientes';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'salary_service_assigned_id',
        'agent_id',
        'code_patiente',
        'approved_units',
        'date_expedition',
        'date_expired'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'salary_service_assigned_id' => 'string',
        'agent_id' => 'string',
        'code_patiente' => 'string',
        'approved_units' => 'string',
        'date_expedition' => 'date',
        'date_expired' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'salary_service_assigned_id' => 'nullable|string|max:255',
        'agent_id' => 'nullable|string|max:255',
        'code_patiente' => 'nullable|string|max:255',
        'approved_units' => 'nullable|string|max:255',
        'date_expedition' => 'date_format:Y-m-d',
        'date_expired' => 'nullable|date_format:Y-m-d|after:date_expedition',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
