<?php

namespace App\Services\LLM\Drivers;

use App\Services\LLM\LLMInterface;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIDriver implements LLMInterface
{
    public function embed(string $text): array
    {
        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-3-large',
            'input' => $text,
        ]);

        return $response->embeddings[0]->embedding;
    }

    public function chat(array $messages): string
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => $messages,
        ]);

        return $response->choices[0]->message->content;
    }
}
