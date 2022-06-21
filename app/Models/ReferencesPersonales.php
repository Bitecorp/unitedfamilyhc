<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="ReferencesPersonales",
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
 *          property="name_job",
 *          description="name_job",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="ocupation",
 *          description="ocupation",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="time",
 *          description="time",
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
class ReferencesPersonales extends Model
{

    use HasFactory;

    public $table = 'references';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'reference_number',
        'name_job',
        'address',
        'phone',
        'ocupation',
        'time'
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
        'name_job' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'ocupation' => 'string',
        'time' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|string|max:255',
        'reference_number' => 'required|string|max:255',
        'name_job' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'ocupation' => 'required|string|max:255',
        'time' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
