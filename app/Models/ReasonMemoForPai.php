<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReasonMemoForPai extends Model
{

    use HasFactory;

    public $table = 'reasons_memos_for_pais';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'worker_id',
        'patiente_id',
        'service_id',
        'sub_service_id',
        'from',
        'to',
        'amount_base',
        'reasons_id',
        'monts_memo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'worker_id' => 'string',
        'patiente_id' => 'string',
        'service_id' => 'string',
        'sub_service_id' => 'string',
        'from' => 'string',
        'to' => 'string',
        'amount_base' => 'string',
        'reasons_id' => 'string',
        'monts_memo' => 'string'
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
        'from' => 'required|string|max:255',
        'to' => 'required|string|max:255',
        'amount_base' => 'required|string|max:255',
        'reasons_id' => 'required|string',
        'monts_memo' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
