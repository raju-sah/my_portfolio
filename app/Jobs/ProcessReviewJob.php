<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Review;
use App\Models\SocialSetting;
use App\Models\User;
use App\Enums\UserType;
use App\Notifications\ReviewNotification;
use App\Mail\ReviewEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ProcessReviewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Review $review, protected array $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send notification to admins
        $users = User::where('user_type', UserType::Admin->value)->get();
        Notification::send($users, new ReviewNotification($this->review));

        // Prepare email data
        $emailData = $this->data;
        $emailData['created_at'] = $this->review->created_at->format('dS M Y g:i A');
        $emailData['article_name'] = Article::where('id', $this->review->article_id)->value('name');

        // Fetch social settings for recipients
        $socialSetting = SocialSetting::first();
        $mails = $socialSetting->email ? explode(',', $socialSetting->email) : ['rajusah0318@gmail.com', 'try.rajusah@gmail.com'];
        $ccmails = ['rajucode7@gmail.com'];

        // Send Email
        Mail::to($mails)->cc($ccmails)->send(new ReviewEmail($emailData));
    }
}
