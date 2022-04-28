<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Insurance",
 *      required={"name_insurance", "documents"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name_insurance",
 *          description="name_insurance",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="documents",
 *          description="documents",
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
class Insurance extends Model
{

    use HasFactory;

    public $table = 'insurances';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name_insurance',
        'documents'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_insurance' => 'string',
        'documents' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_insurance' => 'required|unique:insurances|string|max:255',
        'documents' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
