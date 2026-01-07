<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Product extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id', // Assuming we will have categories
        'image_url',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class);
    }
}
