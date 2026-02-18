<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\SocialSetting;
use App\Models\User;
use App\Enums\UserType;
use App\Notifications\ContactedNotification;
use App\Mail\ContactEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ProcessContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Contact $contact, protected array $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send notification to admins
        $users = User::where('user_type', UserType::Admin->value)->get();
        Notification::send($users, new ContactedNotification($this->contact));

        // Prepare email data
        $emailData = $this->data;
        $emailData['created_at'] = $this->contact->created_at->format('dS M Y g:i A');

        // Fetch social settings for recipients
        $socialSetting = SocialSetting::first();
        $mails = $socialSetting->email ? explode(',', $socialSetting->email) : ['rajusah0318@gmail.com', 'try.rajusah@gmail.com'];
        $ccmails = ['rajucode7@gmail.com'];

        // Send Email
        Mail::to($mails)->cc($ccmails)->send(new ContactEmail($emailData));
    }
}
