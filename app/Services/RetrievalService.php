<?php

namespace App\Services;

use App\Models\DocumentChunk;
use App\Services\LLM\LLMService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RetrievalService
{
    protected $llmService;

    public function __construct(LLMService $llmService)
    {
        $this->llmService = $llmService;
    }

    public function retrieve(string $query, int $limit = 5): Collection
    {
        // 1. Generate Query Embedding via LLMService
        $embedding = null;
        try {
            $embedding = $this->llmService->embed($query);
        } catch (\Exception $e) {
            // Log::warning("Embedding generation failed, falling back to keyword-only search: " . $e->getMessage());
            // Proceed with $embedding = null
        }

        // 2. Hybrid Search (Vector + Keyword)
        // ... (comments)

        // Get candidates via Fulltext (Keyword Search)
        $candidates = DocumentChunk::query()
            ->selectRaw("*, MATCH(content) AGAINST(? IN NATURAL LANGUAGE MODE) as relevance", [$query])
            ->whereRaw("MATCH(content) AGAINST(? IN NATURAL LANGUAGE MODE) > 0", [$query])
            ->limit(50)
            ->get();

        // If no keyword matches, fetch recent chunks as fallback context (or handle empty)
        if ($candidates->isEmpty()) {
            $candidates = DocumentChunk::latest()->limit(50)->get();
        }

        // If we have an embedding, re-rank by vector similarity.
        // If not (e.g. Groq), just return the fulltext results (already ranked by relevance)
        if ($embedding) {
            $ranked = $candidates->map(function ($chunk) use ($embedding) {
                $chunkEmbedding = $chunk->embedding;
                
                // Handle dimension mismatch gracefully
                if (count($chunkEmbedding) !== count($embedding)) {
                    $chunk->similarity = 0;
                    return $chunk;
                }
                
                $chunk->similarity = $this->cosineSimilarity($chunkEmbedding, $embedding);
                return $chunk;
            })->sortByDesc('similarity')->take($limit);
            
            return $ranked;
        }

        return $candidates->take($limit);

        return $ranked;
    }

    private function cosineSimilarity(array $vecA, array $vecB): float
    {
        // Dot product
        $dotProduct = 0;
        foreach ($vecA as $key => $value) {
            $dotProduct += $value * $vecB[$key];
        }
        
        // If vectors are normalized (embeddings are), magnitude is 1.
        // So Similarity = Dot Product.
        return $dotProduct;
    }
}
