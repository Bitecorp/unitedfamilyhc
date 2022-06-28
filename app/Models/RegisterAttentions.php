<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegisterAttentions extends Model
{
    use HasFactory;

    public $table = 'register_attentions';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'worker_id',
        'patiente_id',
        'service_id',
        'sub_service_id',
        'start',
        'lat_start',
        'long_start',
        'end',
        'lat_end',
        'long_end',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'worker_id' => 'string',
        'patiente_id' => 'string',
        'service_id' => 'string',
        'sub_service_id' => 'string',
        'start' => 'datetime',
        'lat_start' => 'string',
        'long_start' => 'string',
        'end' => 'datetime',
        'lat_end' => 'string',
        'long_end' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'worker_id' => 'nullable|string|max:255',
        'patiente_id' => 'nullable|string|max:255',
        'service_id' => 'nullable|string|max:255',
        'sub_service_id' => 'nullable|string|max:255',
        'start' => 'nullable',
        'lat_start' => 'nullable|string|max:255',
        'long_start' => 'nullable|string|max:255',
        'end' => 'nullable',
        'lat_end' => 'nullable|string|max:255',
        'long_end' => 'nullable|string|max:255',
        'status' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
