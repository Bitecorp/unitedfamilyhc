<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="SubServices",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="service_id",
 *          description="service_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name_sub_service",
 *          description="name_sub_service",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="price_sub_service",
 *          description="price_sub_service",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="config_validate",
 *          description="config_validate",
 *          type="string"
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
class SubServices extends Model
{

    use HasFactory;

    public $table = 'sub_services';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'service_id',
        'name_sub_service',
        'price_sub_service',
        'type_salary',
        'config_validate',
        'unit_worker_payment_id',
        'worker_payment',
        'unit_customer_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_id' => 'string',
        'type_salary' => 'boolean',
        'name_sub_service' => 'string',
        'price_sub_service' => 'string',
        'config_validate' => 'string',
        'unit_worker_payment_id' => 'string',
        'worker_payment' => 'string',
        'unit_customer_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'service_id' => 'nullable|string|max:255',
        'name_sub_service' => 'required|string|max:255',
        'price_sub_service' => 'required|string|max:255',
        'type_salary' => 'nullable|boolean',
        'config_validate' => 'nullable|string|max:255',
        'unit_worker_payment_id' => 'nullable|string|max:255',
        'worker_payment' => 'required|string|max:255',
        'unit_customer_id' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
