<?php

namespace App\Services\LLM;

interface LLMInterface
{
    /**
     * Generate embeddings for the given text.
     *
     * @param string $text
     * @return array
     */
    public function embed(string $text): array;

    /**
     * Generate a completion (chat response) for the given messages.
     *
     * @param array $messages
     * @return string
     */
    public function chat(array $messages): string;
}
