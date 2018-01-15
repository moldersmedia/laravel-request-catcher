<?php namespace MoldersMedia\RequestCatcher\Catcher\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property int $status_code
 * @property array $headers
 * @property array $input
 * @property string $locale
 * @property bool $is_secure
 * @property string $url
 * @property string $method
 * @property \Carbon\Carbon $successful_at
 * @property Collection $paths
 * @property $this $original_request
 */
class Request extends Model
{
    /**
     * @var string
     */
    protected $table = 'request_catches';

    /**
     * @var array
     */
    protected $casts = [
        'status_code' => 'integer',
        'headers'     => 'array',
        'input'       => 'array',
        'locale'      => 'string',
        'is_secure'   => 'bool',
        'url'         => 'string',
        'method'      => 'string',
    ];

    public $dates = [
        'successful_at'
    ];

    public function paths()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function original_request()
    {
        return $this->belongsTo(self::class, 'original_id');
    }
}