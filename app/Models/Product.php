<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_DELETED = 'deleted';

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'currency',
        'quantity',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * Get the stock movements for the product.
     *
     * @return HasMany
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Record a stock change.
     *
     * @param int $newQuantity
     * @return void
     */
    public function saveStockChange(int $newQuantity): void
    {
        $difference = $newQuantity - $this->quantity;

        if ($difference !== 0) {
            $this->stockMovements()->create([
                'type' => $difference > 0 ? StockMovement::TYPE_IN : StockMovement::TYPE_OUT,
                'quantity' => $difference,
            ]);
        }

        $this->update([
            'quantity' => (int) $this->stockMovements()->sum('quantity'),
        ]);
    }

    /**
     * Create a new product with a stock change.
     *
     * @param array $data
     * @param int $quantity
     * @return self
     */
    public static function createWithStock(array $data, int $quantity): self
    {
        $product = self::create([
            ...$data,
            'quantity' => 0,
        ]);

        $product->saveStockChange($quantity);

        return $product;
    }

    /**
     * Scope to only return visible products.
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
