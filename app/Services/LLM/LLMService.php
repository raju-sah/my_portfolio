<?php

namespace App\Services\LLM;

use App\Services\LLM\Drivers\OpenRouterDriver;
use Illuminate\Support\Facades\Log;

class LLMService
{
    protected OpenRouterDriver $driver;

    public function __construct()
    {
        $this->driver = new OpenRouterDriver();
    }

    public function embed(string $text): array
    {
        // try OpenRouter first (which also has an OpenAI fallback internally)
        try {
            return $this->driver->embed($text);
        } catch (\Exception $e) {
            Log::warning("Primary embedding (OpenRouter/OpenAI) failed: " . $e->getMessage());
        }

        // Fallback to Hugging Face (Free)
        try {
            Log::info("Attempting Hugging Face fallback for embedding...");
            return (new \App\Services\LLM\Drivers\HuggingFaceDriver())->embed($text);
        } catch (\Exception $e) {
            Log::error("All embedding methods failed.");
            throw $e;
        }
    }


    public function chat(array $messages): string
    {
        try {
            return $this->driver->chat($messages);
        } catch (\Exception $e) {
            Log::error("Chat failed (all models exhausted): " . $e->getMessage());
            throw $e;
        }
    }
}
