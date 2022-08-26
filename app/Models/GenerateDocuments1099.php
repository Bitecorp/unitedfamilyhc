<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenerateDocuments1099 extends Model
{
    use HasFactory;

    public $table = 'generate_documents_1099';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'worker_id',
        'patiente_id',
        'service_id',
        'sub_service_id',
        'from',
        'to',
        'eftor_check',
        'invoice_number'
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
        'from' => 'datetime',
        'to' => 'datetime',
        'eftor_check' => 'string',
        'invoice_number' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'worker_id' => 'required|string|max:255',
        'patiente_id' => 'required|string|max:255',
        'service_id' => 'required|string|max:255',
        'sub_service_id' => 'required|string|max:255',
        'from' => 'required|required',
        'to' => 'required|required',
        'eftor_check' => 'required|string|max:255',
        'invoice_number' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
