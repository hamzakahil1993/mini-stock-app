<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_DELETED = 'deleted';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * Scope to only return visible clients.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('status', '!=', self::STATUS_DELETED);
    }

    /**
     * Resolve the route binding.
     *
     * @param string $value
     * @param string|null $field
     * @return self|null
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        return $this->visible()
            ->where($field ?? $this->getRouteKeyName(), $value)
            ->firstOrFail();
    }
}
