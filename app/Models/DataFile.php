<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DataFile
 * @package App\Models
 * @version July 29, 2021, 5:37 am UTC
 *
 * @property string $name
 * @property string $url
 * @property string $path
 * @property string $ext
 * @property string $mime_type
 * @property boolean $status
 */

class DataFile extends Model
{
    use HasFactory;

    public $table = 'data_files';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'path',
        'ext',
        'mime_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'url' => 'string',
        'path' => 'string',
        'ext' => 'string',
        'mime_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'url' => 'required|string',
        'path' => 'required|string',
        'ext' => 'required|string',
        'mime_type' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}

