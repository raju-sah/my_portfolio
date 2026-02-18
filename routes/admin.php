<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BackgroundController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\HomeSettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\SocialSettingController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::get('/home/draw-chart', [DashboardController::class, 'drawChart'])->name('home.draw-chart');
Route::get('/home/filter-dimensions', [DashboardController::class, 'filterDimensions'])->name('home.filter-dimensions');


Route::group(['middleware' => 'auth', 'prefix' => 'Admin', 'as' => 'admin.'], function () {

    Route::get('profile', [ProfileController::class, 'index'])->name('profiles.index');
    Route::patch('profile-update', [ProfileController::class, 'update'])->name('profiles.update');

    Route::get('status-change-home_setting', [HomeSettingController::class, 'changeStatus'])->name('status-change-home_setting');
    Route::resource('home-settings', HomeSettingController::class);

    Route::get('social-settings', [SocialSettingController::class, 'index'])->name('social-settings.index');
    Route::put('/social-settings/update/{id?}', [SocialSettingController::class, 'update'])->name('social-settings.update');
   
    Route::get('smtp-settings', [SmtpSettingController::class, 'index'])->name('smtp-settings.index');
    Route::put('/smtp/update/{id?}', [SmtpSettingController::class, 'update'])->name('smtp-settings.update');

    Route::get('status-change-project', [ProjectController::class, 'changeStatus'])->name('status-change-project');
    Route::resource('projects', ProjectController::class);

    Route::get('status-change-skill', [SkillController::class, 'changeStatus'])->name('status-change-skill');
    Route::post('update-skill-order', [SkillController::class, 'updateOrder'])->name('skills.update-order');
    Route::resource('skills', SkillController::class);

    Route::get('status-change-experience', [ExperienceController::class, 'changeStatus'])->name('status-change-experience');
    Route::resource('experiences', ExperienceController::class);

    Route::get('status-change-background', [BackgroundController::class, 'changeStatus'])->name('status-change-background');
    Route::resource('backgrounds', BackgroundController::class);

    Route::get('status-change-article', [ArticleController::class, 'changeStatus'])->name('status-change-article');
    Route::post('update-article-order', [ArticleController::class, 'updateOrder'])->name('articles.update-order');
    Route::resource('articles', ArticleController::class);

    Route::get('status-change-review', [ReviewController::class, 'changeStatus'])->name('status-change-review');
    Route::resource('reviews', ReviewController::class)->only(['index', 'show','destroy']);
    Route::get('show-review/{review}', [ReviewController::class, 'showNotification'])->name('reviews.show-notification');

    Route::get('status-change-testimonial', [TestimonialController::class, 'changeStatus'])->name('status-change-testimonial');
    Route::resource('testimonials', TestimonialController::class);

    Route::resource('contacts', ContactController::class);
    Route::get('show-contact-notification/{contact}', [ContactController::class, 'showNotification'])->name('contacts.show-notification');

    // Valentine Reports
    Route::resource('valentines', \App\Http\Controllers\Admin\ValentineController::class)->only(['index', 'show', 'destroy']);


    Route::get('article/reports', [ReportController::class, 'articleReport'])->name('article-reports.index');
    Route::get('article/filters', [ReportController::class, 'reportFilter'])->name('article-reports.filters');
    Route::get('/generate-pdf', [ReportController::class, 'generatePDF'])->name('article.generate-pdf');

    //---------------------------------------- Notification List -------------------------------------------------
    Route::get('all-notifications', function () {
        return view('admin.notifications.index', [
            'notifications' => auth()->user()->notifications
        ]);
    })->name('all-notifications');



    Route::get('/email/verify', function () {
        return view('admin.auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::get('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});
