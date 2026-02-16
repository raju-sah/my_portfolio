<?php

namespace App\Services;

use App\Models\DocumentChunk;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

class IngestionService
{
    protected $llm;

    public function __construct(\App\Services\LLM\LLMService $llm)
    {
        $this->llm = $llm;
    }

    public function ingestResume(string $path)
    {
        Log::info("Ingesting Resume from: {$path}");
        
        $text = (new Pdf())->setPdf($path)->text();
        $this->processContent($text, 'resume', ['path' => $path]);
    }

    public function ingestWebsite(string $url)
    {
        Log::info("Ingesting Website: {$url} via Firecrawl");
        
        // Call Firecrawl API (POST /v0/scrape)
        // Note: In production you'd use a dedicated client or the command line tool if available.
        // We use Laravel's Http client here for simplicity.
        $apiKey = env('FIRECRAWL_API_KEY');
        if (!$apiKey) {
            Log::warning("Skipping Website ingestion: FIRECRAWL_API_KEY not set");
            return;
        }

        $response = \Illuminate\Support\Facades\Http::withToken($apiKey)
            ->post('https://api.firecrawl.dev/v0/scrape', [
                'url' => $url,
                'pageOptions' => ['onlyMainContent' => true]
            ]);

        if ($response->successful()) {
            $markdown = $response->json('data.markdown');
            $this->processContent($markdown, 'website', ['url' => $url]);
        } else {
            Log::error("Firecrawl failed for {$url}: " . $response->body());
        }
    }

    public function ingestGitHub(string $username)
    {
        Log::info("Ingesting GitHub for: {$username}");
        
        // Fetch Pinned or Top Repos
        $response = \Illuminate\Support\Facades\Http::get("https://api.github.com/users/{$username}/repos?sort=updated&per_page=5");
        
        if ($response->successful()) {
            foreach ($response->json() as $repo) {
                $description = $repo['description'] ?? '';
                $readmeUrl = str_replace('github.com', 'raw.githubusercontent.com', $repo['html_url']) . '/master/README.md';
                
                $readme = \Illuminate\Support\Facades\Http::get($readmeUrl)->body();
                if (str_contains($readme, '404: Not Found')) {
                    $readme = "No README available.";
                }

                $content = "Repo: {$repo['name']}\nDescription: {$description}\nStack: {$repo['language']}\n\nREADME:\n{$readme}";
                $this->processContent($content, 'github', ['repo' => $repo['html_url']]);
            }
        }
    }

    public function ingestSocials(string $jsonPath)
    {
        // "Curated Content" ingestion as requested
        Log::info("Ingesting Curated Socials from: {$jsonPath}");
        
        if (!file_exists($jsonPath)) {
            Log::warning("Socials JSON not found at {$jsonPath}");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        foreach ($data as $post) {
            $content = "Platform: {$post['platform']}\nDate: {$post['date']}\nContent: {$post['content']}";
            $this->processContent($content, 'social', ['platform' => $post['platform']]);
        }
    }

    private function processContent(string $text, string $sourceType, array $metadata)
    {
        $cleanText = $this->cleanText($text);
        $chunks = $this->splitText($cleanText, 800, 100);
        
        foreach ($chunks as $chunk) {
            $embedding = null;
            try {
                $embedding = $this->generateEmbedding($chunk);
            } catch (\Exception $e) {
                // Log warning but proceed with null embedding for keyword search support
                Log::warning("Embedding generation skipped for chunk: " . $e->getMessage());
            }

            try {
                DocumentChunk::create([
                    'content' => $chunk,
                    'embedding' => $embedding,
                    'source_type' => $sourceType,
                    'metadata' => $metadata,
                    'token_count' => strlen($chunk) / 4
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to save DocumentChunk: " . $e->getMessage());
            }
        }
        Log::info("Ingested " . count($chunks) . " chunks from {$sourceType}");
    }

    private function cleanText(string $text): string
    {
        // Remove excessive whitespace, weird characters
        return preg_replace('/\s+/', ' ', trim($text));
    }

    private function splitText(string $text, int $maxTokens, int $overlap): array
    {
        // Simple character-based splitter for now (1 token ~= 4 chars)
        // Ideally use a tokenizer, but this works for v1
        $maxChars = $maxTokens * 4;
        $overlapChars = $overlap * 4;
        
        $chunks = [];
        $length = strlen($text);
        
        for ($i = 0; $i < $length; $i += ($maxChars - $overlapChars)) {
            $chunks[] = substr($text, $i, $maxChars);
        }
        
        return $chunks;
    }

    private function generateEmbedding(string $text): array
    {
        return $this->llm->embed($text);
    }
}
