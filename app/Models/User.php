<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        'avatar',
        'bg_avatar'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
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
        'companie_agent' => 'string',
        'avatar' => 'string',
        'bg_avatar' => 'string',
    ];
}
