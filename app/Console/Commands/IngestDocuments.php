<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IngestionService;

class IngestDocuments extends Command
{
    protected $signature = 'rag:ingest {type : Any name for the source type} {target : File path, URL, or Username}';
    protected $description = 'Ingest documents (PDFs are handled dynamically, others via specialized handlers)';

    /**
     * Execute the console command.
     */
    public function handle(IngestionService $ingestionService)
    {
        $type = $this->argument('type');
        $target = $this->argument('target');

        $this->info("Starting ingestion for [{$type}]: {$target}");

        try {
            // Check if target is a PDF file to handle it dynamically
            if (is_file($target) && strtolower(pathinfo($target, PATHINFO_EXTENSION)) === 'pdf') {
                $ingestionService->ingestPdf($target, $type);
            } else {
                match ($type) {
                    'website' => $ingestionService->ingestWebsite($target),
                    'github' => $ingestionService->ingestGitHub($target),
                    'social' => $ingestionService->ingestSocials($target),
                    default => $this->error("Unknown type or unsupported file extension for: {$type}")
                };
            }
            
            $this->info("Ingestion completed successfully.");
        } catch (\Exception $e) {
            $this->error("Ingestion failed: " . $e->getMessage());
        }
    }
}
