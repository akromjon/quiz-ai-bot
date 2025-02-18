<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Quiz as QuizModel;
use App\Models\QuizRequest;
use App\Models\Question;
use App\Exceptions\WordGenerationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;

class WordService
{
    private const WORD_DIRECTORY = 'word';
    private const FILE_EXTENSION = '.docx';
    private const WORD_FORMAT = 'Word2007';
    private const STORAGE_DISK = 'public'; // Changed to public disk

    private static ?self $instance = null;
    private PhpWord $phpWord;

    private function __construct(PhpWord $phpWord = null)
    {
        $this->phpWord = $phpWord ?? new PhpWord();
    }

    public static function make(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get or generate Word document URL for the given UUID
     *
     * @param string $uuid
     * @return string
     * @throws WordGenerationException
     */
    public function get(string $uuid): string
    {
        $filePath = $this->getFilePath($uuid);

        if (!Storage::disk(self::STORAGE_DISK)->exists($filePath)) {
            return $this->generateWord($uuid);
        }

        return Storage::disk(self::STORAGE_DISK)->url($filePath);
    }

    /**
     * Generate Word document for the given UUID
     *
     * @param string $uuid
     * @return string
     * @throws WordGenerationException
     */
    private function generateWord(string $uuid): string
    {
        $quizzes = $this->getQuizzes($uuid);

        if ($quizzes->isEmpty()) {
            throw new WordGenerationException("No quizzes found for UUID: {$uuid}");
        }

        $section = $this->phpWord->addSection();
        $this->addQuestionContent($section, $quizzes);

        return $this->saveDocument($uuid);
    }

    /**
     * Add questions content to the Word document section
     *
     * @param Section $section
     * @param Collection $quizzes
     */
    private function addQuestionContent(Section $section, Collection $quizzes): void
    {
        $questionNumber = 1;

        foreach ($quizzes as $quiz) {
            foreach ($quiz->questions as $question) {
                $this->addQuestion($section, $question, $questionNumber);
                $questionNumber++;
            }
        }
    }

    /**
     * Add a single question with its options to the document
     *
     * @param Section $section
     * @param Question $question
     * @param int $questionNumber
     */
    private function addQuestion(Section $section, Question $question, int $questionNumber): void
    {
        // Add question text
        $section->addText(
            "{$questionNumber}. Savol",
            ['bold' => true],
            ['spacing' => 120]
        );

        $section->addText(
            $question->text,
            [],
            ['spacing' => 120]
        );

        // Add options
        foreach ($question->options as $option) {

            $optionText = $option->text;

            if($option->is_correct){
                $optionText .= ' ✅';
            }

            $section->addText(
                $optionText,
                [],
                ['spacing' => 120]
            );
        }

        // Add spacing after each question
        $section->addText('', [], ['spacing' => 240]);
    }

    /**
     * Save the Word document
     *
     * @param string $uuid
     * @return string
     * @throws WordGenerationException
     */
    private function saveDocument(string $uuid): string
    {
        try {
            $filePath = $this->getFilePath($uuid);

            // Create directory in public storage
            Storage::disk(self::STORAGE_DISK)->makeDirectory(self::WORD_DIRECTORY);

            // Get full path in public storage
            $fullPath = Storage::disk(self::STORAGE_DISK)->path($filePath);

            $writer = IOFactory::createWriter($this->phpWord, self::WORD_FORMAT);
            $writer->save($fullPath);

            return Storage::disk(self::STORAGE_DISK)->url($filePath);
        } catch (\Exception $e) {
            throw new WordGenerationException(
                "Failed to save Word document: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

    /**
     * Get quizzes for the given UUID
     *
     * @param string $uuid
     * @return Collection
     * @throws WordGenerationException
     */
    private function getQuizzes(string $uuid): Collection
    {
        $quizRequest = QuizRequest::where('uuid', $uuid)->first();

        if (!$quizRequest) {
            throw new WordGenerationException("Quiz request not found for UUID: {$uuid}");
        }

        return $quizRequest->quizzes;
    }

    /**
     * Get file path for the given UUID
     *
     * @param string $uuid
     * @return string
     */
    private function getFilePath(string $uuid): string
    {
        return self::WORD_DIRECTORY . '/' . $uuid . self::FILE_EXTENSION;
    }
}
