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
    public string $type = "";
    public string $format = "";
    public int $number_of_question = 10;
    public string $language="";
    public string $difficulty="";
    public function mount(): void
    {
        $this->type = Type::MULTIPLE_CHOICE->value;
        $this->number_of_question = NumberOfQuestion::TEN->value;
        $this->format = Format::LINK->value;
        $this->language=Language::UZBEK->value;
        $this->difficulty=Difficulty::INTERMEDIATE->value;
    }

    protected function rules(): array
    {
        return [
            'text' => ['required','min:3','max:300'],
            'type' => ['required', Rule::enum(type: Type::class)],
            'number_of_question' => ['required', Rule::enum(type: NumberOfQuestion::class)],
            'format' => ['required', Rule::enum(type: Format::class)],
            'language' => ['required', Rule::enum(type: Language::class)],
            'difficulty' => ['required', Rule::enum(type: Difficulty::class)],
        ];
    }
    public function render(): View
    {
        return view(view: 'livewire.quiz.request.index');
    }

    public function submit(): void
    {
        $this->validate();

        $req=QuizRequestModel::create([
            'user_id'=>0,
            'status'=>Status::PENDING,
            'text'=>$this->text,
            'language'=>$this->language,
            'format'=>$this->format,
            'difficulty'=>$this->difficulty,
            'number_of_question'=>$this->number_of_question,
            'type'=>$this->type,
        ]);

        QuizGeneratorJob::dispatch($req);

    }
}
