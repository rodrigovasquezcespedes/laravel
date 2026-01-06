<?php

namespace App\Traits;

use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    /**
     * The "booted" method of the model.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (app()->has('currentTenant')) {
                $builder->where('store_id', app('currentTenant')->id);
            }
        });

        static::creating(function ($model) {
            if (app()->has('currentTenant')) {
                $model->store_id = app('currentTenant')->id;
            }
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
