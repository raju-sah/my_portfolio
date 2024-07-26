<?php

use App\Http\Controllers\frontend\FrontArticleController;
use App\Http\Controllers\frontend\WebsiteController;
use App\Http\Controllers\HomeController;
use App\Mail\ContactEmail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/getmacshellexec',function()
    {
        $shellexec = exec('getmac'); 
        dd($shellexec);
    }
);

Route::get('cmd', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    echo "Success !!";
});


Auth::routes( [ 'register' => false ] );

Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/all-projects', [WebsiteController::class, 'show'])->name('projects.all');

Route::get('/article/{slug}', [FrontArticleController::class, 'showArticle'])->name('article.detail');
Route::get('/articles/all', [FrontArticleController::class, 'allArticleFilter'])->name('articles.all');

Route::post('/contact/store', [WebsiteController::class, 'storeContact'])->name('contact.store');
Route::post('articles/rating', [WebsiteController::class, 'storeRating'])->name('articles.rating.store');
Route::get('articles/rating/{id}', [WebsiteController::class, 'showRating'])->name('articles.rating.index');



Route::get('/sendWithCCandBCC', function(Request $request) {
    $mainRecipients = ['rajucode7@gmail.com'];
    $ccRecipients = ['crajusah0318@gmail.com', 'try.rajusah@gmail.com'];
    $contact = $request->all();

    Mail::to($mainRecipients)
        ->cc($ccRecipients)
        ->send(new ContactEmail($contact));
})->name('sendWithCCandBCC');


Route::get('/notifications/{notification}', function (DatabaseNotification $notification) {
    $notification->markAsRead();
})->name('mark_as_read');

Route::get('mark-all-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('mark_all_as_read');