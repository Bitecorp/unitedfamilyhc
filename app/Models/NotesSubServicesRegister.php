<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class NotesSubServicesRegister extends Model
{

    use HasFactory;

    public $table = 'notes_sub_services_registers';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'register_attentions_id',
        'worker_id',
        'patiente_id',
        'service_id',
        'sub_service_id',
        'note',
        'firma'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'register_attentions_id' => 'string',
        'worker_id' => 'string',
        'patiente_id' => 'string',
        'service_id' => 'string',
        'sub_service_id' => 'string',
        'note' => 'string',
        'firma' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'register_attentions_id' => 'required|string|max:255',
        'worker_id' => 'required|string|max:255',
        'patiente_id' => 'required|string|max:255',
        'service_id' => 'required|string|max:255',
        'sub_service_id' => 'required|string|max:255',
        'note' => 'nullable|string',
        'firma' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}