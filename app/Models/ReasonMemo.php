<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReasonMemo extends Model
{

    use HasFactory;

    public $table = 'reasons_memos';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'title_reason'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title_reason' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title_reason' => 'required|unique:reasons_memos|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
