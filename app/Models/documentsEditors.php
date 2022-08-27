<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="documentsEditors",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name_document_editor",
 *          description="name_document_editor",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class documentsEditors extends Model
{

    use HasFactory;

    public $table = 'documents_editors';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name_document_editor',
        'role_id',
        'backgroundImg',
        'pagination',
        'content',
        'service_id',
        'paginate',
        'isTemplate',
        'type_template'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_document_editor' => 'string',
        'backgroundImg' => 'string',
        'role_id' => 'string',
        'content' => 'string',
        'service_id' => 'string',
        'paginate' => 'boolean',
        'isTemplate' => 'boolean',
        'type_template' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_document_editor' => 'nullable|unique:documents_editors|string',
        'content' => 'nullable|string',
        'backgroundImg' => 'nullable|string',
        'role_id' => 'nullable|string|max:255',
        'service_id' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'paginate' => 'nullable|string',
        'isTemplate' => 'nullable|boolean',
        'type_template' => 'nullable|string|max:255'
    ];
}
