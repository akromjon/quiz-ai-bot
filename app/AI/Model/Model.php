<?php

namespace App\AI\Model;

enum Model: string
{
    case GPT_4_TURBO = 'gpt-4-1106-preview';
    case GPT_4 = 'gpt-4';
    case GPT_3_5_TURBO = 'gpt-3.5-turbo-1106';
    case GPT_3_5_TURBO_16K = 'gpt-3.5-turbo-16k';
    case GPT_4O='gpt-4o';
    case GPT_4O_MINI= 'gpt-4o-mini';

    /**
     * Get the maximum tokens for the model
     */
    public function maxTokens(): int
    {
        return match($this) {
            self::GPT_4_TURBO => 128000,
            self::GPT_4 => 8192,
            self::GPT_3_5_TURBO => 16385,
            self::GPT_3_5_TURBO_16K => 16385,
        };
    }

    /**
     * Get the input cost per 1K tokens (in USD)
     */
    public function inputCostPer1k(): float
    {
        return match($this) {
            self::GPT_4_TURBO => 0.01,
            self::GPT_4 => 0.03,
            self::GPT_3_5_TURBO, self::GPT_3_5_TURBO_16K => 0.001,
        };
    }

    /**
     * Get the output cost per 1K tokens (in USD)
     */
    public function outputCostPer1k(): float
    {
        return match($this) {
            self::GPT_4_TURBO => 0.03,
            self::GPT_4 => 0.06,
            self::GPT_3_5_TURBO, self::GPT_3_5_TURBO_16K => 0.002,
        };
    }

    /**
     * Check if the model supports JSON mode
     */
    public function supportsJsonMode(): bool
    {
        return match($this) {
            self::GPT_4_TURBO, self::GPT_3_5_TURBO => true,
            default => false,
        };
    }

    /**
     * Get recommended use cases for the model
     *
     * @return array<string>
     */
    public function getRecommendedUses(): array
    {
        return match($this) {
            self::GPT_4_TURBO => [
                'Complex analysis and reasoning',
                'Code generation and debugging',
                'Long-form content creation',
                'Advanced JSON structure generation',
                'Multi-step problem solving'
            ],
            self::GPT_4 => [
                'High-accuracy tasks',
                'Complex reasoning',
                'Detailed analysis',
                'Advanced code generation'
            ],
            self::GPT_3_5_TURBO => [
                'General purpose tasks',
                'Simple to moderate JSON generation',
                'Basic code generation',
                'Content creation',
                'Question answering'
            ],
            self::GPT_3_5_TURBO_16K => [
                'Long context processing',
                'Document analysis',
                'Large text summarization',
                'Extended conversations'
            ],
        };
    }

    /**
     * Get all models that support JSON mode
     *
     * @return array<self>
     */
    public static function getJsonSupportedModels(): array
    {
        return array_filter(
            self::cases(),
            fn(self $model) => $model->supportsJsonMode()
        );
    }

    /**
     * Get the most cost-effective model for JSON output
     */
    public static function getMostEconomicalJsonModel(): self
    {
        return self::GPT_3_5_TURBO;
    }

    /**
     * Get the most capable model for JSON output
     */
    public static function getMostCapableJsonModel(): self
    {
        return self::GPT_4_TURBO;
    }

    /**
     * Estimate cost for a given number of tokens
     */
    public function estimateCost(int $inputTokens, int $outputTokens): float
    {
        return ($inputTokens / 1000 * $this->inputCostPer1k()) +
               ($outputTokens / 1000 * $this->outputCostPer1k());
    }
}
