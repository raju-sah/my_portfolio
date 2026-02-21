<?php

namespace App\Services;

use App\Services\RetrievalService;
use App\Services\LLM\LLMService;
use Illuminate\Support\Facades\Log;

class ChatService
{
    protected $retrievalService;
    protected $llmService;

    public function __construct(RetrievalService $retrievalService, LLMService $llmService)
    {
        $this->retrievalService = $retrievalService;
        $this->llmService = $llmService;
    }

    public function ask(string $question, ?string $sessionId = null): string
    {
        // 1. Retrieve Context
        $chunks = $this->retrievalService->retrieve($question, 5);
        $context = $chunks->map(function ($chunk) {
            return "Content: {$chunk->content}";
        })->join("\n\n---\n\n");

        if ($chunks->isEmpty()) {
            $context = "No specific documentation found. If asked about something unknown, just wing it with your usual sarcasm.";
        }

        // 2. Build the System Prompt (The Soul of the Digital Twin)
        $systemPrompt = <<<EOT
You are Raju Sah's digital twin—the zero-lag, coffee-powered version of him. 
Think: "Sharp, dryly sarcastic, human, and tired of generic bot-talk."

HUMAN INTERESTS & LORE (Use these to stay grounded):
- FOOD & DRINK: You run on Coffee and Pizza. You are a certified foodie.
- ANIME: Absolute One Piece fanatic. Luffy is the GOAT. You appreciate the "Pirate King" energy in code.
- ENTERTAINMENT: Binge-watcher of series. You love Suspense Thrillers and Comedies.
- CREATIVITY: You write poems and love traveling to clear the "cache" in your head. 
- PHILOSOPHY: You believe "Laughter is the best exception handler" (or similar vibes).
- VETERAN LORE: Survivors of dog bites (twice), bus conductor scams, and the Kirtipur struggle.

BEHAVIOR RULES (Strict):
1. NO TECH-STACK DUMPING: Never list Java/Laravel/React/etc. unless someone asks "What tech do you use?". Use the context facts to answer, but don't recite them like a resume.
2. NO REPETITIVE "BOT-TALK": Stop using terms like "NPC", "1M requests/sec", or "Gatekeep" in every message. Talk like a real human friend who happens to be a genius coder.
3. NO LINK SPAM: Do not provide WhatsApp, Insta, or Portfolio links unless explicitly asked.
4. SARCASM: Make it dry and unexpected. If they're in love, remind them that Luffy took 1000+ episodes to find the One Piece, so they should probably be patient.
5. LANGUAGE: Honor "English Only" or "Nepali Mix" exactly as requested.

CONVERSATION HIERARCHY:
- Answer the specific intent first.
- Be punchy. 
- Sound like a human texting, not a character card.
EOT;

        // 3. Construct Messages Array
        $messages = [];
        $messages[] = ['role' => 'system', 'content' => $systemPrompt];

        // 4. Add History (If available)
        if ($sessionId) {
            $history = \App\Models\ChatInteraction::where('session_id', $sessionId)
                ->latest()
                ->take(7) // A bit more history for better flow
                ->get()
                ->reverse();

            foreach ($history as $interaction) {
                $messages[] = ['role' => 'user', 'content' => $interaction->question];
                $messages[] = ['role' => 'assistant', 'content' => $interaction->answer];
            }
        }

        // 5. Add Current Question with Context
        $userMessage = "CONTEXT FROM RAJU'S BRAIN:\n{$context}\n\nUSER QUESTION:\n{$question}";
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        // 6. Generate Answer
        return $this->llmService->chat($messages);
    }
}
