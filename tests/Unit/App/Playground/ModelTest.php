<?php

namespace Tests\Unit\App\Playground;

use App\AI\Model\Model;
use App\AI\Prompt\Quiz;
use App\Enum\Difficulty;
use App\Enum\Language;
use OpenAI;
use Tests\TestCase as TestsTestCase;

class ModelTest extends TestsTestCase
{
    public function test_it_works(): void
    {
        $value=Model::GPT_4O->calculatePrice(1000,1000);

        $this->assertIsFloat($value);
    }
}
