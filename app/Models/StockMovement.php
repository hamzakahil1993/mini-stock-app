<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    public const TYPE_IN = 'IN';

    public const TYPE_OUT = 'OUT';

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
    ];

    /**
     * Get the product that the stock movement belongs to.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
