<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataAmountsNotes extends Model
{

    use HasFactory;

    public $table = 'data_amounts_notes';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'note_id',
        'customer_billing',
        'type_customer',
        'patiente_unit_time_id',
        'worker_payment',
        'type_payment',
        'worker_unit_time_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'note_id' => 'string',
        'customer_billing' => 'string',
        'type_customer' => 'string',
        'patiente_unit_time_id' => 'string',
        'worker_payment' => 'string',
        'type_payment' => 'string',
        'worker_unit_time_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'note_id' => 'required|string',
        'customer_billing' => 'required|string',
        'type_customer' => 'required|string',
        'patiente_unit_time_id' => 'required|string',
        'worker_payment' => 'required|string',
        'type_payment' => 'required|string',
        'worker_unit_time_id' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
