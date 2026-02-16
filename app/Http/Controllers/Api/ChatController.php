<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
            'session_id' => 'nullable|string|max:255',
        ]);

        try {
            $question = $request->input('question');
            
            // Priority: Request Input -> Laravel Native Session -> Generated UUID (fallback)
            $sessionId = $request->input('session_id') ?: 
                         ($request->hasSession() ? $request->session()->getId() : (string) \Illuminate\Support\Str::uuid());

            $answer = $this->chatService->ask($question, $sessionId);
            
            // Log interaction
            \App\Models\ChatInteraction::create([
                'question' => $question,
                'answer' => $answer,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $sessionId,
            ]);

            return response()->json([
                'answer' => $answer,
                'session_id' => $sessionId
            ]);
        } catch (\Exception $e) {
            Log::error("Chat Error: " . $e->getMessage());
            return response()->json(['error' => 'Raju is taking a nap. Try again later.'], 500);
        }
    }
}
