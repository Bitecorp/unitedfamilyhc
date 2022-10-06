<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ConnectionsExternals
 * @package App\Models
 * @version October 6, 2022, 4:54 pm UTC
 *
 * @property string $name_connection
 * @property string $server_connection
 * @property string $port_connection
 * @property string $user_connection
 * @property string $password_connection
 */
class ConnectionsExternals extends Model
{
    use HasFactory;

    public $table = 'connections_externals';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name_connection',
        'server_connection',
        'port_connection',
        'user_connection',
        'password_connection'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_connection' => 'string',
        'server_connection' => 'string',
        'port_connection' => 'string',
        'user_connection' => 'string',
        'password_connection' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_connection' => 'nullable|string|max:255',
        'server_connection' => 'nullable|string|max:255',
        'port_connection' => 'nullable|string|max:255',
        'user_connection' => 'nullable|string|max:255',
        'password_connection' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
