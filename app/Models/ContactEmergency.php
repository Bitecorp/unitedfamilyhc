<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="ContactEmergency",
 *      required={"user_id", "first_name", "last_name"},
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
 *          property="first_name",
 *          description="first_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last_name",
 *          description="last_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="mi",
 *          description="mi",
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
class ContactEmergency extends Model
{

    use HasFactory;

    public $table = 'contacts_emergencys';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'mi',
        'street_addres',
        'apartment_unit',
        'city',
        'state',
        'zip_code',
        'home_phone',
        'alternate_phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'mi' => 'string',
        'street_addres' => 'string',
        'apartment_unit' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip_code' => 'string',
        'home_phone' => 'string',
        'alternate_phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string|max:255',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'mi' => 'nullable|string|max:255',
        'street_addres' => 'required|string|max:255',
        'apartment_unit' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip_code' => 'required|string|max:255',
        'home_phone' => 'required|string|max:255',
        'alternate_phone' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
