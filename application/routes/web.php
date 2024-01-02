<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\CommentController;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');


    //Guest User  Route

    Route::get('/', 'index')->name('home');

    Route::get('/post-details/{id}', 'postDetails')->name('post.details');
    Route::get('/post/{category_name}/{id}', 'categoryPost')->name('post.category');
    Route::get('/job/post', 'jobPost')->name('post.job');
    Route::get('/popular/post', 'popularPost')->name('post.popular');
    Route::get('/user-profile/{user}', 'user_profile')->name('user.profile.details');
    Route::post('/search', 'User\PostController@search')->name("post.search");
    
    //Guest User  Route

    Route::middleware('auth')->group(function () {

        Route::get('/post', 'textPost')->name('text.post');
        Route::get('/job', 'addJobPost')->name('add.post.job');
        Route::get('/save-post', 'savePost')->name('save.post');

        Route::controller(PostController::class)->name('post.')->group(function () {
            Route::post('/post-vote', 'post_vote')->name("vote");
            Route::post('/post-bookmark', 'post_bookmark')->name("bookmark");
            Route::post('/post-report', 'post_report')->name("report");
        });

        Route::controller(CommentController::class)->group(function () {
            Route::post('/comment', 'comment_create')->name("comment");
            Route::post('/comment-edit', 'comment_edit')->name("comment.edit");
            Route::post('/comment-delete', 'comment_delete')->name("comment.delete");
            Route::post('/replay-comment', 'comment_reply')->name("comment.replay");
            Route::post('/comment-vote', 'comment_vote')->name("comment.vote");
            Route::post('/comment-report', 'comment_report')->name("comment.report");
        });
    });

    Route::get('/profile', 'profile')->name('profile');
    Route::get('/{slug}', 'pages')->name('pages');
});



