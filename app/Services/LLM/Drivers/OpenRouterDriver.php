<?php

namespace App\Services\LLM\Drivers;

use App\Services\LLM\LLMInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterDriver implements LLMInterface
{
    protected string $apiKey;
    protected string $baseUrl = 'https://openrouter.ai/api/v1';
    protected array $preferredModels;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');

        // Preferred models in fallback order (tried top to bottom)
        $modelsConfig = config('services.openrouter.preferred_models', '');
        $this->preferredModels = $modelsConfig
            ? array_map('trim', explode(',', $modelsConfig))
            : [
                'openai/gpt-5',
                'x-ai/grok-4.1-fast',
                'google/gemini-3-flash-preview',
                'deepseek/deepseek-chat',
                'minimax/minimax-m2.5',
                'moonshotai/kimi-k2.5',
                'arcee-ai/trinity-large-preview:free',
            ];
    }

    public function embed(string $text): array
    {
        $model = config('services.openrouter.embedding_model', 'openai/text-embedding-3-small');
        
        try {
            $response = Http::withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'HTTP-Referer' => config('app.url', 'https://sahraju.com.np'),
                    'X-Title' => 'RajuGPT Portfolio Chatbot',
                    'Content-Type' => 'application/json',
                ])
                ->timeout(60)
                ->post("{$this->baseUrl}/embeddings", [
                    'model' => $model,
                    'input' => $text,
                ]);

            if ($response->successful()) {
                return $response->json('data.0.embedding');
            }

            throw new \Exception("OpenRouter embedding failed ({$response->status()}): " . $response->body());
        } catch (\Exception $e) {
            Log::warning("OpenRouter embedding failed, trying OpenAI fallback: " . $e->getMessage());
            // Fallback to OpenAI (original behavior)
            return (new OpenAIDriver())->embed($text);
        }
    }


    public function chat(array $messages): string
    {
        $lastException = null;

        foreach ($this->preferredModels as $model) {
            try {
                $result = $this->callChat($model, $messages);
                return $result;
            } catch (\Exception $e) {
                $lastException = $e;
                Log::warning("OpenRouter model '{$model}' failed: " . $e->getMessage());
                continue;
            }
        }

        Log::error("All OpenRouter models failed. Tried: " . implode(' → ', $this->preferredModels));
        throw $lastException ?? new \Exception("All OpenRouter models failed.");
    }

    protected function callChat(string $model, array $messages): string
    {
        /*
        include these parameters in every API call. This is the most effective way to stop the spam or repeating the same thing.
         frequency_penalty: 0.4: Penalizes words based on how often they've appeared so far.
         presence_penalty: 0.3: Encourages the model to talk about new topics.
         temperature: 0.85: Gives it enough "creativity" to vary its sarcasm.
        */
        $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'HTTP-Referer' => config('app.url', 'https://sahraju.com.np'),
                'X-Title' => 'RajuGPT Portfolio Chatbot',
                'Content-Type' => 'application/json',
            ])
            ->timeout(60)
            ->post("{$this->baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.85,
                'frequency_penalty' => 0.4,
                'presence_penalty' => 0.3,
                'stream' => false,
            ]);

        if (!$response->successful()) {
            throw new \Exception("OpenRouter [{$model}] failed ({$response->status()}): " . $response->body());
        }

        $content = $response->json('choices.0.message.content');

        if (!$content) {
            throw new \Exception("OpenRouter [{$model}]: No content in response.");
        }

        Log::info("OpenRouter chat succeeded with model: {$model}");
        return $content;
    }
}
