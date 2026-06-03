<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClickModel extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $table = 'clicks';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'short_url_id',
        'ip',
        'user_agent',
        'referer',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'immutable_datetime',
        ];
    }

    public function shortUrl(): BelongsTo
    {
        return $this->belongsTo(ShortUrlModel::class, 'short_url_id');
    }
}
