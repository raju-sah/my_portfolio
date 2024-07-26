<?php

namespace App\Providers;

use App\Models\BackForthText;
use App\Models\HomeSetting;
use App\Models\SocialSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $home_setting = Cache::rememberForever('home_settings', function () {
            return HomeSetting::query()->select('title','logo', 'image', 'description',)->latest()->first();
        });

        $social_links = Cache::rememberForever('social_links', function () {
            return SocialSetting::query()->select('email', 'phone', 'address', 'facebook_url', 'insta_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'github_url')->latest()->get();
        });

        $backforthtext = Cache::rememberForever('backforthtext', function () {
            return BackForthText::query()->select('name')->latest()->get();
        });

        View::share('backforthtext', $backforthtext);

        View::share('social_links', $social_links);

        View::share('home_setting', $home_setting);
    }
}
