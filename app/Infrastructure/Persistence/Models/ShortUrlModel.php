<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortUrlModel extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $table = 'short_urls';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'original_url',
        'short_code',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'immutable_datetime',
        ];
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(ClickModel::class, 'short_url_id');
    }
}
