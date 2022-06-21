<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

/**
 * @SWG\Definition(
 *      definition="Agent",
 *      required={"first_name", "last_name", "email", "password", "role_id", "statu_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
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
 *          property="ssn",
 *          description="ssn",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="birth_date",
 *          description="birth_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="marital_state",
 *          description="marital_state",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email_verified_at",
 *          description="email_verified_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="role_id",
 *          description="role_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="statu_id",
 *          description="statu_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="remember_token",
 *          description="remember_token",
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
class Agent extends Model
{
    use HasFactory;

    public $table = 'users';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'first_name',
        'last_name',
        'mi',
        'street_addres',
        'apartment_unit',
        'city',
        'state',
        'zip_code',
        'home_phone',
        'alternate_phone',
        'ssn',
        'birth_date',
        'marital_status',
        'email',
        'email_verified_at',
        'password',
        'role_id',
        'statu_id',
        'remember_token',
        'companie_agent',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'mi' => 'string',
        'street_addres' => 'string',
        'apartment_unit' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip_code' => 'string',
        'home_phone' => 'string',
        'alternate_phone' => 'string',
        'ssn' => 'string',
        'birth_date' => 'date',
        'marital_status' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'role_id' => 'string',
        'statu_id' => 'string',
        'remember_token' => 'string',
        'companie_agent' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
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
        'ssn' => 'nullable|string|unique:users|max:255',
        'birth_date' => 'nullable|date_format:Y-m-d',
        'marital_status' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'nullable|string|max:255',
        'role_id' => 'required|string|max:255',
        'statu_id' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'companie_agent' => 'nullable|string|max:100',
    ];

     /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesUpdate = [
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
        'ssn' => 'nullable|string|max:255',
        'birth_date' => 'nullable|date_format:Y-m-d',
        'marital_status' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'nullable|string|max:255',
        'role_id' => 'required|string|max:255',
        'statu_id' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'companie_agent' => 'nullable|string|max:100',
    ];
}
