<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Companies",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="street_addres",
 *          description="street_addres",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="apartment_unit",
 *          description="apartment_unit",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="city",
 *          description="city",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="state",
 *          description="state",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="zip_code",
 *          description="zip_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="home_phone",
 *          description="home_phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="alternate_phone",
 *          description="alternate_phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="ssn",
 *          description="ssn",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
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
class Companies extends Model
{

    use HasFactory;

    public $table = 'companies';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'name',
        'street_addres',
        'apartment_unit',
        'city',
        'state',
        'zip_code',
        'home_phone',
        'alternate_phone',
        'ssn',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'name' => 'string',
        'street_addres' => 'string',
        'apartment_unit' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip_code' => 'string',
        'home_phone' => 'string',
        'alternate_phone' => 'string',
        'ssn' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'street_addres' => 'nullable|string|max:255',
        'apartment_unit' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'zip_code' => 'nullable|string|max:255',
        'home_phone' => 'nullable|string|max:255',
        'alternate_phone' => 'nullable|string|max:255',
        'ssn' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
