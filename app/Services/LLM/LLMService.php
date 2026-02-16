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
        try {
            return $this->driver->embed($text);
        } catch (\Exception $e) {
            Log::error("Embedding failed: " . $e->getMessage());
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
