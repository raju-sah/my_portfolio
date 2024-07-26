<?php

namespace App\Providers;

use App\Models\BackForthText;
use App\Models\HomeSetting;
use App\Models\SocialSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class WebsiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // try {
        //     // header
        //     $home_setting = HomeSetting::query()->select('title', 'logo', 'image', 'description', 'pdf_file')->latest()->first();
        //     $social_links = SocialSetting::query()->select('email', 'phone', 'address', 'facebook_url', 'insta_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'github_url')->latest()->get();
        //     $backforthtext = BackForthText::query()->select('name')->latest()->get();
        //     View::share('home_setting', $home_setting);
        //     View::share('social_links', $social_links);
        //     View::share('backforthtext', $backforthtext);
        // } catch (QueryException $e) {

        //     View::share('home_setting', $home_setting);
        //     View::share('social_links', $social_links);
        //     View::share('backforthtext', $backforthtext);
        // }
    }
}
