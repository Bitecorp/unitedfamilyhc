<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="ConfirmationIndependent",
 *      required={"independent_contractor"},
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
 *          property="independent_contractor",
 *          description="independent_contractor",
 *          type="boolean"
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
class ConfirmationIndependent extends Model
{

    use HasFactory;

    public $table = 'confirmations';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'independent_contractor',
        'personalEmpresa'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'independent_contractor' => 'string',
        'personalEmpresa' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string|max:255',
        'independent_contractor' => 'string|max:255',
        'personalEmpresa' => 'string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
