<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="DocumentUserFiles",
 *      required={"file"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="document_id",
 *          description="document_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date_expedition",
 *          description="date_expedition",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="date_expired",
 *          description="date_expired",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="file",
 *          description="file",
 *          type="string"
 *      )
 * )
 */
class DocumentUserFiles extends Model
{

    use HasFactory;

    public $table = 'document_user_files';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'user_id',
        'document_id',
        'date_expedition',
        'date_expired',
        'expired',
        'file'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'document_id' => 'string',
        'date_expedition' => 'date',
        'date_expired' => 'date',
        'expired' => 'string',
        'file' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|string',
        'document_id' => 'nullable|string',
        'date_expedition' => 'date_format:Y-m-d',
        'date_expired' => 'nullable|date_format:Y-m-d|after:date_expedition',
        'file' => 'nullable|mimes:jpeg,png,pdf',
        'expired' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
