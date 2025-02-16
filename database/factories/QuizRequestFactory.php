<?php

namespace Database\Factories;

use App\Enum\Difficulty;
use App\Enum\Format;
use App\Enum\Language;
use App\Enum\NumberOfQuestion;
use App\Enum\Status;
use App\Enum\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizRequest>
 */
class QuizRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'=>fake()->numberBetween(1,100000),
            'user_id' => User::factory(),
            'uuid' => fake()->uuid(),
            'status' => fake()->randomElement(Status::cases()),
            'reason' => null,
            'text' => fake()->text(),
            'language' => fake()->randomElement(Language::cases()),
            'format' => fake()->randomElement(Format::cases()),
            'difficulty' => fake()->randomElement(Difficulty::cases()),
            'number_of_question' => fake()->randomElement(NumberOfQuestion::cases()),
            'type' => fake()->randomElement(Type::cases())
        ];
    }

    /**
     * Indicate that the quiz request is pending.
     */
    public function pending(): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => Status::PENDING,
            'reason' => null,
        ]);
    }

    /**
     * Indicate that the quiz request is processing.
     */
    public function processing(): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => Status::PROCESSING,
            'reason' => null,
        ]);
    }

    /**
     * Indicate that the quiz request is completed.
     */
    public function completed(): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => Status::COMPLETED,
            'reason' => null,
        ]);
    }

    /**
     * Indicate that the quiz request has failed.
     */
    public function failed(array $reason = ['message' => 'Generation failed']): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => Status::FAILED,
            'reason' => json_encode($reason),
        ]);
    }
}
