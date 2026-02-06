<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\ValentineSubmission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ValentineController extends Controller
{
    /**
     * Display the main Valentine landing page.
     */
    public function index(): View
    {
        $dayConfig = ValentineSubmission::getDayConfig();
        $today = now()->format('m-d');

        // Mark active days
        foreach ($dayConfig as $key => &$day) {
            $day['is_active'] = $today >= $day['date'];
            $day['is_today'] = $today === $day['date'];
        }

        // Valentine's Day countdown
        $valentineDate = now()->year . '-02-14 00:00:00';
        if (now()->gt($valentineDate)) {
            $valentineDate = (now()->year + 1) . '-02-14 00:00:00';
        }

        return view('valentine.index', [
            'dayConfig' => $dayConfig,
            'valentineDate' => $valentineDate,
        ]);
    }

    /**
     * Store a new valentine submission.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'day_type' => 'required|in:rose,propose,chocolate,teddy,promise,hug,kiss,valentine',
        ]);

        $submission = new ValentineSubmission();
        $submission->sender_name = $validated['sender_name'];
        $submission->message = $validated['message'];
        $submission->day_type = $validated['day_type'];

        // Generate love quote and date idea
        $submission->meta_data = [
            'love_quote' => $this->getRandomLoveQuote(),
            'date_idea' => $this->getRandomDateIdea(),
        ];

        $submission->save();

        return response()->json([
            'success' => true,
            'share_url' => $submission->share_url,
            'uuid' => $submission->uuid,
        ]);
    }

    /**
     * Display the receiver page for a submission.
     */
    public function show(string $uuid): View
    {
        $submission = ValentineSubmission::where('uuid', $uuid)->firstOrFail();
        $submission->incrementOpenCount();

        $dayConfig = ValentineSubmission::getDayConfig();
        $currentDayConfig = $dayConfig[$submission->day_type] ?? null;

        return view('valentine.show', [
            'submission' => $submission,
            'dayConfig' => $currentDayConfig,
            'isValentineDay' => $submission->day_type === 'valentine',
        ]);
    }

    /**
     * Handle interaction (like, accept, reject).
     */
    public function interact(Request $request, string $uuid): JsonResponse
    {
        $submission = ValentineSubmission::where('uuid', $uuid)->firstOrFail();
        $action = $request->input('action');

        switch ($action) {
            case 'like':
                $submission->incrementLikesCount();
                break;
            case 'accept':
                $submission->markAsAccepted();
                break;
            case 'reject':
                $submission->markAsRejected();
                break;
        }

        return response()->json([
            'success' => true,
            'submission' => $submission->fresh(),
            'meta_data' => $submission->meta_data,
        ]);
    }

    /**
     * Generate QR code for a submission.
     */
    public function qrCode(string $uuid): mixed
    {
        $submission = ValentineSubmission::where('uuid', $uuid)->firstOrFail();

        return response(QrCode::size(250)->generate($submission->share_url))
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Get tracker data for user's submissions.
     */
    public function tracker(Request $request): JsonResponse
    {
        // For now, get all submissions (in production, filter by user/session)
        $submissions = ValentineSubmission::latest()->take(20)->get();

        return response()->json([
            'submissions' => $submissions->map(function ($s) {
                return [
                    'uuid' => $s->uuid,
                    'sender_name' => $s->sender_name,
                    'day_type' => $s->day_type,
                    'status' => $s->status,
                    'open_count' => $s->open_count,
                    'likes_count' => $s->likes_count,
                    'accepted_at' => $s->accepted_at?->format('M d, Y H:i'),
                    'rejected_at' => $s->rejected_at?->format('M d, Y H:i'),
                    'created_at' => $s->created_at->format('M d, Y H:i'),
                    'share_url' => $s->share_url,
                ];
            }),
        ]);
    }

    /**
     * Get a random love quote.
     */
    private function getRandomLoveQuote(): string
    {
        $quotes = [
            "You are the reason I believe in love. ❤️",
            "Every love story is beautiful, but ours is my favorite. 💕",
            "In a sea of people, my eyes will always search for you. 👀💖",
            "I fell in love the way you fall asleep: slowly, then all at once. 😴❤️",
            "You're my today and all of my tomorrows. 🌅",
            "I love you not only for what you are, but for what I am when I am with you. 🥰",
            "Together is a wonderful place to be. 🏠💑",
            "You make my heart smile. 😊❤️",
            "I choose you. And I'll choose you over and over. 💍",
            "Love is not about how many days, months, or years you've been together. It's about how much you love each other every day. 📅❤️",
        ];

        return $quotes[array_rand($quotes)];
    }

    /**
     * Get a random date idea.
     */
    private function getRandomDateIdea(): array
    {
        $ideas = [
            ['icon' => '🎬', 'title' => 'Movie Date', 'description' => 'Cozy up with popcorn and a romantic movie'],
            ['icon' => '🧺', 'title' => 'Picnic', 'description' => 'Pack some snacks and enjoy nature together'],
            ['icon' => '🍽', 'title' => 'Candle Dinner', 'description' => 'A romantic dinner with candles and soft music'],
            ['icon' => '☕', 'title' => 'Coffee Date', 'description' => 'A cozy café with your favorite drinks'],
            ['icon' => '🌆', 'title' => 'Night Walk', 'description' => 'Stroll under the stars hand in hand'],
            ['icon' => '🎡', 'title' => 'Fun Park', 'description' => 'Enjoy rides and win prizes together'],
            ['icon' => '🏞', 'title' => 'Nature Date', 'description' => 'Hiking or exploring a beautiful trail'],
            ['icon' => '🎮', 'title' => 'Gaming Date', 'description' => 'Play video games and challenge each other'],
            ['icon' => '📸', 'title' => 'Photo Walk', 'description' => 'Capture beautiful moments around the city'],
            ['icon' => '🎨', 'title' => 'Art Date', 'description' => 'Visit a gallery or paint together'],
        ];

        return $ideas[array_rand($ideas)];
    }
}
