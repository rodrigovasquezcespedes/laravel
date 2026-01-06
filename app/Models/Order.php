<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Order extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
        'transaction_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
