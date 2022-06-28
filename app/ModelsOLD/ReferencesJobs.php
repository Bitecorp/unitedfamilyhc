<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="ReferencesJobs",
 *      required={""},
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
 *          property="name_and_address",
 *          description="name_and_address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          description="position",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="supervisor",
 *          description="supervisor",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone_supervisor",
 *          description="phone_supervisor",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="dates_employed",
 *          description="dates_employed",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="to_dates_employed",
 *          description="to_dates_employed",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="reason_leaving",
 *          description="reason_leaving",
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
class ReferencesJobs extends Model
{

    use HasFactory;

    public $table = 'references_jobs';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'reference_number',
        'name_and_address',
        'position',
        'supervisor',
        'phone_supervisor',
        'dates_employed',
        'to_dates_employed',
        'reason_leaving'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'reference_number' => 'string',
        'name_and_address' => 'string',
        'position' => 'string',
        'supervisor' => 'string',
        'phone_supervisor' => 'string',
        'dates_employed' => 'string',
        'to_dates_employed' => 'string',
        'reason_leaving' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string|max:255',
        'reference_number' => 'nullable|string|max:255',
        'name_and_address' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'supervisor' => 'nullable|string|max:255',
        'phone_supervisor' => 'nullable|string|max:255',
        'dates_employed' => 'nullable|string|max:255',
        'to_dates_employed' => 'nullable|string|max:255',
        'reason_leaving' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
