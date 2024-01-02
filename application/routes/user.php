<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ApplyJobController;
use App\Http\Controllers\User\UserNotificationController;

Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });
    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller('SocialiteController')->prefix('social')->group(function () {
        Route::get('login/{provider}', 'socialLogin')->name('social.login');
        Route::get('login/callback/{provider}', 'callback')->name('social.login.callback');
    }); 
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend/verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify/email', 'emailVerification')->name('verify.email');
        Route::post('verify/mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify/g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('data', 'User\UserController@userData')->name('data');
        Route::post('user/data/submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {
            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');
                Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile/setting', 'profile')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('profile-image', 'profileImageUpdate')->name('profile.image.upload');
                Route::get('experience', 'experience')->name('experience.index');
                Route::post('experience/store', 'experienceStore')->name('experience.store');
                Route::get('experience/edit/{experience}', 'experienceEdit')->name('experience.edit');
                Route::post('experience/update/{experience}', 'experienceUpdate')->name('experience.update');
                Route::get('experience/delete/{id}', 'experienceDelete')->name('experience.delete');
            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::get('/', 'withdrawMoney');
                Route::post('/', 'withdrawStore')->name('.money');
                Route::get('preview', 'withdrawPreview')->name('.preview');
                Route::post('preview', 'withdrawSubmit')->name('.submit');
                Route::get('history', 'withdrawLog')->name('.history');
            });

            // User Post 
            Route::controller(PostController::class)->prefix('post')->name('post.')->group(function () {
                Route::post('/store', 'store')->name("store");
                Route::get('/edit/{id}', 'edit')->name("edit");
                Route::post('/update/{id}', 'update')->name("update");
                Route::get('/job', 'job')->name("job");
                Route::post('/status', 'postStatus')->name("status");
                Route::post('/image', 'postImage')->name("image");
            });

            // Apply job Controller
            Route::controller(ApplyJobController::class)->name('apply.job.')->group(function () {
                Route::post('/store', 'store')->name("store");
                Route::get('/all-candidate/{id}', 'all_candidate')->name("all.candidate");
                Route::get('/download-file/{id}', 'download_file')->name("download.file");
            });

            // User Price Plan 
            Route::controller('PricePlanController')->prefix('price-plan')->name('price.plan.')->group(function () {
                Route::get('/', 'index')->name("index");
                Route::get('/{price_plan}', 'insert')->name("insert");
            });

            // User Refill Plan 
            Route::controller('RefillPlanController')->prefix('refill-plan')->name('refill.plan.')->group(function () {
                Route::get('/', 'index')->name("index");
                Route::get('/{refill_plan}', 'insert')->name("insert");
            });

            // User Notification
            Route::controller('UserNotificationController')->prefix('notification')->name('notification.')->group(function () {
                Route::get('/', 'index')->name("index");
                Route::get('/read-status/{id}', 'read_status')->name("read.status");
                Route::get('/delete/{id}', 'delete')->name("delete");
            });

            // User Chat
            Route::controller('ChatController')->prefix('chat')->name('chat.')->group(function () {
                Route::post('/', 'store')->name("store");
                Route::get('/download-file/{id}', 'download_file')->name("download.file");
            });

        });
        // Payment
        Route::middleware('registration.complete')->controller('Gateway\PaymentController')->group(function () {
            Route::any('deposit', 'deposit')->name('deposit');
            Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
            Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
        });
    });
});
