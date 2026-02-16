<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IngestionService;

class IngestDocuments extends Command
{
    protected $signature = 'rag:ingest {type : resume, website, github, or social} {target : File path, URL, or Username}';
    protected $description = 'Ingest documents from various sources (PDF, Web, GitHub, JSON)';

    /**
     * Execute the console command.
     */
    public function handle(IngestionService $ingestionService)
    {
        $type = $this->argument('type');
        $target = $this->argument('target');

        $this->info("Starting ingestion for [{$type}]: {$target}");

        try {
            match ($type) {
                'resume' => $ingestionService->ingestResume($target),
                'website' => $ingestionService->ingestWebsite($target),
                'github' => $ingestionService->ingestGitHub($target),
                'social' => $ingestionService->ingestSocials($target),
                default => $this->error("Unknown type: {$type}")
            };
            
            $this->info("Ingestion completed successfully.");
        } catch (\Exception $e) {
            $this->error("Ingestion failed: " . $e->getMessage());
        }
    }
}
