<?php

namespace App\AI\Model;

enum Model: string
{
    case GPT_4_TURBO = 'gpt-4-1106-preview';
    case GPT_4 = 'gpt-4';
    case GPT_3_5_TURBO = 'gpt-3.5-turbo-1106';
    case GPT_3_5_TURBO_16K = 'gpt-3.5-turbo-16k';
    case GPT_4O = 'gpt-4o';
    case GPT_4O_MINI = 'gpt-4o-mini';

    /**
     * Calculate the price in USD based on token usage
     *
     * @param int $promptTokens Number of tokens used in the prompt
     * @param int $completionTokens Number of tokens used in the completion
     * @return float Price in USD
     */
    public function calculatePrice(int $promptTokens, int $completionTokens): float
    {
        $value= match($this) {
            self::GPT_4_TURBO => ($promptTokens / 1000 * 0.01) + ($completionTokens / 1000 * 0.03),
            self::GPT_4 => ($promptTokens / 1000 * 0.03) + ($completionTokens / 1000 * 0.06),
            self::GPT_3_5_TURBO => ($promptTokens / 1000 * 0.0015) + ($completionTokens / 1000 * 0.002),
            self::GPT_3_5_TURBO_16K => ($promptTokens / 1000 * 0.003) + ($completionTokens / 1000 * 0.004),
            self::GPT_4O => ($promptTokens / 1000 * 0.005) + ($completionTokens / 1000 * 0.015),
            self::GPT_4O_MINI => ($promptTokens / 1000 * 0.00015) + ($completionTokens / 1000 * 0.0006),
        };

        return round($value,6);
    }

    /**
     * Get the price per 1K tokens for input (prompt)
     *
     * @return float Price per 1K tokens for input
     */
    public function getInputPrice(): float
    {
        return match($this) {
            self::GPT_4_TURBO => 0.01,
            self::GPT_4 => 0.03,
            self::GPT_3_5_TURBO => 0.0015,
            self::GPT_3_5_TURBO_16K => 0.003,
            self::GPT_4O => 0.005,
            self::GPT_4O_MINI => 0.00015,
        };
    }

    /**
     * Get the price per 1K tokens for output (completion)
     *
     * @return float Price per 1K tokens for output
     */
    public function getOutputPrice(): float
    {
        return match($this) {
            self::GPT_4_TURBO => 0.03,
            self::GPT_4 => 0.06,
            self::GPT_3_5_TURBO => 0.002,
            self::GPT_3_5_TURBO_16K => 0.004,
            self::GPT_4O => 0.015,
            self::GPT_4O_MINI => 0.0006,
        };
    }

    /**
     * Calculate the price breakdown for token usage
     *
     * @param int $promptTokens Number of tokens used in the prompt
     * @param int $completionTokens Number of tokens used in the completion
     * @return array Price breakdown details
     */
    public function calculatePriceDetails(int $promptTokens, int $completionTokens): array
    {
        $inputPrice = ($promptTokens / 1000) * $this->getInputPrice();
        $outputPrice = ($completionTokens / 1000) * $this->getOutputPrice();
        $totalPrice = $inputPrice + $outputPrice;

        return [
            'model' => $this->value,
            'prompt_tokens' => $promptTokens,
            'completion_tokens' => $completionTokens,
            'total_tokens' => $promptTokens + $completionTokens,
            'input_cost' => round($inputPrice, 6),
            'output_cost' => round($outputPrice, 6),
            'total_cost' => round($totalPrice, 6),
            'input_rate' => $this->getInputPrice(),
            'output_rate' => $this->getOutputPrice(),
            'currency' => 'USD'
        ];
    }
}
