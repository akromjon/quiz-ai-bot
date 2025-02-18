<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enum\Difficulty;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Enum\NumberOfQuestion;
use Livewire\Component;
use App\Enum\Format;
use App\Enum\Language;
use App\Enum\Status;
use App\Enum\Type;
use App\Jobs\QuizGeneratorJob;
use App\Models\QuizRequest as QuizRequestModel;

class QuizRequest extends Component
{
    public string $text = "";
    public int $number_of_question = 10;
    public string $language = "";
    public string $difficulty = "";

    private const ALLOWED_QUESTION_VALUES = [10, 20, 30, 40];

    public function mount(): void
    {
        $this->language = Language::UZBEK->value;
        $this->difficulty = Difficulty::INTERMEDIATE->value;
        $this->number_of_question = self::ALLOWED_QUESTION_VALUES[0];
    }

    protected function rules(): array
    {
        return [
            'text' => ['required', 'min:3', 'max:2000'],
            'number_of_question' => [
                'required',
                Rule::enum(type: NumberOfQuestion::class),
            ],
            'language' => ['required', Rule::enum(type: Language::class)],
            'difficulty' => ['required', Rule::enum(type: Difficulty::class)],
        ];
    }

    public function render(): View
    {
        return view('livewire.quiz.request.index', [
            'minDisabled' => $this->isMinDisabled(),
            'maxDisabled' => $this->isMaxDisabled(),
        ]);
    }

    public function submit(): void
    {
        $this->validate();

        $req = QuizRequestModel::create([
            'type' => Type::MULTIPLE_CHOICE,
            'format' => Format::ALL,
            'user_id' => 0,
            'status' => Status::PENDING,
            'text' => $this->text,
            'language' => $this->language,
            'difficulty' => $this->difficulty,
            'number_of_question' => $this->number_of_question,
        ]);


        QuizGeneratorJob::dispatch($req);

        $this->reset();

        $this->redirect(route('quiz.status', ['uuid' => $req->uuid]));
    }

    public function minusHandler(): void
    {
        $currentIndex = array_search($this->number_of_question, self::ALLOWED_QUESTION_VALUES);

        if ($currentIndex > 0) {
            $this->number_of_question = self::ALLOWED_QUESTION_VALUES[$currentIndex - 1];
            $this->validateOnly('number_of_question');
        }
    }

    public function plusHandler(): void
    {
        $currentIndex = array_search($this->number_of_question, self::ALLOWED_QUESTION_VALUES);

        if ($currentIndex !== false && $currentIndex < count(self::ALLOWED_QUESTION_VALUES) - 1) {
            $this->number_of_question = self::ALLOWED_QUESTION_VALUES[$currentIndex + 1];
            $this->validateOnly('number_of_question');
        }
    }

    private function isMinDisabled(): bool
    {
        return $this->number_of_question <= min(self::ALLOWED_QUESTION_VALUES);
    }

    private function isMaxDisabled(): bool
    {
        return $this->number_of_question >= max(self::ALLOWED_QUESTION_VALUES);
    }
}
