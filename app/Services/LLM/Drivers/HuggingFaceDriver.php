<?php

namespace App\Services\LLM\Drivers;

use App\Services\LLM\LLMInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HuggingFaceDriver implements LLMInterface
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = env('HUGGING_FACE_API_KEY', '');
        $this->model = env('HUGGING_FACE_EMBEDDING_MODEL', 'sentence-transformers/all-MiniLM-L6-v2');
    }

    public function embed(string $text): array
    {
        $url = "https://router.huggingface.co/hf-inference/models/{$this->model}";

        try {
            $response = Http::withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->timeout(30)
                ->post($url, [
                    'inputs' => $text,
                ]);

            if ($response->successful()) {
                $embedding = $response->json();
                
                // HF can return a nested array if it's a sequence-to-sequence model
                // For sentence-transformers, it's usually a flat array
                return is_array($embedding[0]) ? $embedding[0] : $embedding;
            }

            throw new \Exception("Hugging Face embedding failed ({$response->status()}): " . $response->body());
        } catch (\Exception $e) {
            Log::error("Hugging Face Driver Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function chat(array $messages): string
    {
        // Hugging Face inference for chat is limited, but could be implemented similarly
        throw new \Exception("Chat not implemented for Hugging Face driver yet.");
    }
}
