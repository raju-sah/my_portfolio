<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IngestionService;
use Illuminate\Support\Facades\Log;

class SyncKnowledge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rag:sync-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automated sync for GitHub and Website knowledge sources';

    /**
     * Execute the console command.
     */
    public function handle(IngestionService $ingestionService)
    {
        $this->info("Starting Automated Knowledge Sync...");
        Log::info("CRON: Starting rag:sync-all");

        try {
            // 1. Ingest GitHub
            $githubUser = 'raju-sah';
            $this->comment("Syncing GitHub: {$githubUser}...");
            $ingestionService->ingestGitHub($githubUser);
            $this->info("GitHub sync completed.");

            // 2. Ingest Website
            $websiteUrl = 'https://sahraju.com.np/';
            $this->comment("Syncing Website: {$websiteUrl}...");
            $ingestionService->ingestWebsite($websiteUrl);
            $this->info("Website sync completed.");

            $this->info("All knowledge sources synchronized successfully!");
            Log::info("CRON: rag:sync-all completed successfully");
        } catch (\Exception $e) {
            $this->error("Sync failed: " . $e->getMessage());
            Log::error("CRON: rag:sync-all failed: " . $e->getMessage());
        }
    }
}
