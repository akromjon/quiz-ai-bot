<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Quiz extends Model
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
