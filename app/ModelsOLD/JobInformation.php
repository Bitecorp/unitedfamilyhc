<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="JobInformation",
 *      required={"title", "supervisor", "work_name_location", "work_phone", "salary"},
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
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="supervisor",
 *          description="supervisor",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="work_name_location",
 *          description="work_name_location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="work_phone",
 *          description="work_phone",
 *          type="string"
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
class JobInformation extends Model
{

    use HasFactory;

    public $table = 'jobs_information';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'user_id',
        'title',
        'supervisor',
        'work_name_location',
        'work_phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'title' => 'string',
        'supervisor' => 'string',
        'work_name_location' => 'string',
        'work_phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string|max:255',
        'title' => 'required|string|max:255',
        'supervisor' => 'required|string|max:255',
        'work_name_location' => 'required|string|max:255',
        'work_phone' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
