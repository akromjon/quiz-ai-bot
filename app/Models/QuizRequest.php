<?php

namespace App\Models;

use App\Enum\Difficulty;
use App\Enum\Format;
use App\Enum\Language;
use App\Enum\NumberOfQuestion;
use App\Enum\Status;
use App\Enum\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class QuizRequest extends Model
{
    use HasFactory;
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'number_of_question' => NumberOfQuestion::class,
            'language' => Language::class,
            'difficulty' => Difficulty::class,
            'format' => Format::class,
            'type' => Type::class,
        ];
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class);
    }
}
