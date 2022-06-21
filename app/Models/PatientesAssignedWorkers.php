<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientesAssignedWorkers extends Model
{

    use HasFactory;

    public $table = 'patientes_assigned_workers';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'patiente_id',
        'worker_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'patiente_id' => 'string',
        'worker_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patiente_id' => 'nullabel|string|max:255',
        'worker_id' => 'nullabel|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
