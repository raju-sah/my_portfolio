<?php

namespace App\Http\Controllers\frontend;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use App\Http\Requests\Admin\ReviewStoreRequest;
use App\Mail\ContactEmail;
use App\Mail\ReviewEmail;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Review;
use App\Models\Skill;
use App\Models\SocialSetting;
use App\Models\User;
use App\Notifications\ContactedNotification;
use App\Notifications\ReviewNotification;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Spatie\Analytics\Period;

class WebsiteController extends Controller
{
    public function index(AnalyticsService $analyticsService): View
    {
        $startDate = Carbon::parse('2024-05-25')->startOfDay();
        $endDate = Carbon::now();
        $period = Period::create($startDate, $endDate);

        return view('layouts.front_includes.main', [
            
            'usersAndViews' => $analyticsService->getAnalyticsData($period, ['screenPageViews', 'activeUsers'], [])->first(),
            
                'projects' => Project::query()->select('id', 'name', 'year', 'tech_used', 'web_url', 'github_url', 'description', 'image')->where('status', 1)->orderBy('display_order')->latest()->get(),

                'skills' => Skill::query()
                    ->select(['id', 'name', 'description', 'percentage', 'image'])
                    ->where('status', 1)
                    ->orderBy('display_order')
                    ->limit(5)
                    ->get(),

                'experiences' => Experience::query()
                    ->select(['id', 'name', 'description', 'image', 'web_url', 'role', 'location', 'date_from', 'date_to', 'curently_here'])
                    ->where('status', 1)
                    ->orderBy('display_order')
                    ->get(),

                'articles' => Article::query()
                    ->select(['id', 'name', 'description', 'image', 'slug', 'views', 'min_read', 'about', 'created_at'])
                    ->where('status', 1)
                    ->withAvgRating()
                    ->orderBy('reviews_avg_rating', 'desc')
                    ->limit(5)
                    ->get(),
        ]);
    }

    public function show(): View
    {
        return view('frontend.project.all_projects', [
            'projects' => Project::query()
                ->select(['id', 'name', 'year', 'tech_used', 'web_url', 'github_url', 'description', 'image'])
                ->where('status', 1)
                ->orderBy('display_order')
                ->get(),
        ]);
    }
    public function storeContact(ContactRequest $request): JsonResponse
    {
        $data = $request->safe()->except('g-recaptcha-response');
        $contact = Contact::create($data);

        $users = User::where('user_type', UserType::Admin->value)->get();
        Notification::send($users, new ContactedNotification($contact));

        $data['created_at'] = now()->format('dS M Y g:i A');

        $socialSetting = SocialSetting::first();
        $mails = $socialSetting->email ? explode(',', $socialSetting->email) : ['rajusah0318@gmail.com', 'try.rajusah@gmail.com'];
        $ccmails = ['rajucode7@gmail.com'];
        Mail::to($mails)->cc($ccmails)->send(new ContactEmail($data));

        return response()->json(['message' => 'Thank you for reaching Out! I will get back to you soon😊. Peace Out✌️.'], 201);
    }

    public function storeRating(ReviewStoreRequest $request): JsonResponse
    {
        $data = $request->safe()->except('g-recaptcha-response');
        $review = Review::create($data);
        $users = User::where('user_type', UserType::Admin->value)->get();
        Notification::send($users, new ReviewNotification($review));

        $data['created_at'] = now()->format('dS M Y g:i A');
        $data['article_name'] = Article::where('id', $request->article_id)->value('name');

        $socialSetting = SocialSetting::first();
        $mails = $socialSetting->email ? explode(',', $socialSetting->email) : ['rajusah0318@gmail.com', 'try.rajusah@gmail.com'];
        $ccmails = ['rajucode7@gmail.com'];
        Mail::to($mails)->cc($ccmails)->queue(new ReviewEmail($data));

        return response()->json([
            'message' => 'Thanks for your feedback!',
            'review' => $review,
        ]);
    }

    public function showRating($id): JsonResponse
    {
        $article = Article::findOrFail($id);

        $reviews = $article->reviews()->select('id', 'name', 'email', 'description', 'rating', 'created_at')->where('status', 1)->latest()->get();

        return response()->json(['reviews' => $reviews]);
    }
}
