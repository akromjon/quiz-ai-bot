<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Quiz as QuizModel;
use App\Models\QuizRequest;
use App\Models\Question;
use App\Exceptions\PdfGenerationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    private const PDF_DIRECTORY = 'pdf';
    private const FILE_EXTENSION = '.pdf';
    private const STORAGE_DISK = 'public';

    private static ?self $instance = null;

    private function __construct()
    {
        // Initialize any PDF-specific settings here
    }

    public static function make(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get or generate PDF document URL for the given UUID
     *
     * @param string $uuid
     * @return string
     * @throws PdfGenerationException
     */
    public function get(string $uuid): string
    {
        $filePath = $this->getFilePath($uuid);

        if (!Storage::disk(self::STORAGE_DISK)->exists($filePath)) {
            return $this->generatePdf($uuid);
        }

        return Storage::disk(self::STORAGE_DISK)->url($filePath);
    }

    /**
     * Generate PDF document for the given UUID
     *
     * @param string $uuid
     * @return string
     * @throws PdfGenerationException
     */
    private function generatePdf(string $uuid): string
    {
        try {
            $quizzes = $this->getQuizzes($uuid);

            if ($quizzes->isEmpty()) {
                throw new PdfGenerationException("No quizzes found for UUID: {$uuid}");
            }

            $data = [
                'quizzes' => $quizzes,
            ];

            $pdf = PDF::loadView('pdf.index', $data);

            // Optional PDF configurations
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);

            return $this->saveDocument($uuid, $pdf);
        } catch (\Exception $e) {
            throw new PdfGenerationException(
                "Failed to generate PDF: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

    /**
     * Save the PDF document
     *
     * @param string $uuid
     * @param \Barryvdh\DomPDF\PDF $pdf
     * @return string
     * @throws PdfGenerationException
     */
    private function saveDocument(string $uuid, $pdf): string
    {
        try {
            $filePath = $this->getFilePath($uuid);

            // Create directory in public storage
            Storage::disk(self::STORAGE_DISK)->makeDirectory(self::PDF_DIRECTORY);

            // Get full path in public storage
            $fullPath = Storage::disk(self::STORAGE_DISK)->path($filePath);

            // Save the PDF to the specified path
            $pdf->save($fullPath);

            return Storage::disk(self::STORAGE_DISK)->url($filePath);
        } catch (\Exception $e) {
            throw new PdfGenerationException(
                "Failed to save PDF document: {$e->getMessage()}",
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
     * @throws PdfGenerationException
     */
    private function getQuizzes(string $uuid): Collection
    {
        $quizRequest = QuizRequest::where('uuid', $uuid)->first();

        if (!$quizRequest) {
            throw new PdfGenerationException("Quiz request not found for UUID: {$uuid}");
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
        return self::PDF_DIRECTORY . '/' . $uuid . self::FILE_EXTENSION;
    }
}
