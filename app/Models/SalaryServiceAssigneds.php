<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="SalaryServiceAssigneds",
 *      required={"type_salary"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="service_id",
 *          description="service_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type_salary",
 *          description="type_salary",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="salary",
 *          description="salary",
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
class SalaryServiceAssigneds extends Model
{

    use HasFactory;

    public $table = 'salary_service_assigneds';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'service_id',
        'type_salary',
        'salary',
        'customer_payment',
        'frequency',
        'billin_code',
        'aditional_one',
        'aditional_two',
        'aditional_three',
        'aditional_four',
        'workerIdIc',
        'aditional_one_w',
        'aditional_two_w',
        'aditional_three_w'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'service_id' => 'string',
        'type_salary' => 'boolean',
        'salary' => 'string',
        'customer_payment' => 'string',
        'frequency' => 'string',
        'billin_code' => 'string',
        'aditional_one' => 'string',
        'aditional_two' => 'string',
        'aditional_three' => 'string',
        'aditional_four' => 'string',
        'workerIdIc' => 'string',
        'aditional_one_w' => 'string',
        'aditional_two_w' => 'string',
        'aditional_three_w' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string|max:255',
        'service_id' => 'nullable|string|max:255',
        'type_salary' => 'nullable|boolean',
        'salary' => 'nullable|string|max:255',
        'customer_payment' => 'nullable|string|max:255',
        'frequency' => 'nullable|string|max:255',
        'billin_code' => 'nullable|string|max:255',
        'aditional_one' => 'nullable|string|max:255',
        'aditional_two' => 'nullable|string|max:255',
        'aditional_three' => 'nullable|string|max:255',
        'aditional_four' => 'nullable|string|max:255',
        'workerIdIc' => 'nullable|string|max:255',
        'aditional_one_w' => 'nullable|string|max:255',
        'aditional_two_w' => 'nullable|string|max:255',
        'aditional_three_w' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
