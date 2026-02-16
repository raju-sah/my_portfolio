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
        ]);

        try {
            $answer = $this->chatService->ask($request->input('question'));
            
            return response()->json([
                'answer' => $answer
            ]);
        } catch (\Exception $e) {
            Log::error("Chat Error: " . $e->getMessage());
            return response()->json(['error' => 'Raju is taking a nap. Try again later.'], 500);
        }
    }
}
