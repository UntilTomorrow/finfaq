<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Deposit;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\SupportTicket;
use App\Models\UserNotification;
use App\Models\AdminNotification;
use App\Models\PostCommentReport;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $general = gs();
        $activeTemplate = activeTemplate();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['emptyMessage'] = 'No data';
        view()->share($viewShare);

        view()->composer('admin.components.tabs.user', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
            ]);
        });

        view()->composer('admin.components.tabs.post', function ($view) {
            $view->with([
                'pendingPostsCount'           => Post::pending()->count(),
                'rejectedPostsCount'          => Post::rejected()->count()
            ]);
        });

        view()->composer('admin.components.tabs.deposit', function ($view) {
            $view->with([
                'pendingDepositsCount'    => Deposit::pending()->count(),
            ]);
        });


        view()->composer('admin.components.tabs.ticket', function ($view) {
            $view->with([
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0, 2])->count(),
            ]);
        });

        view()->composer('admin.components.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'            => User::banned()->count(),
                'emailUnverifiedUsersCount'   => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'  => User::mobileUnverified()->count(),
                'pendingTicketCount'          => SupportTicket::whereIN('status', [0, 2])->count(),
                'pendingDepositsCount'        => Deposit::pending()->count(),
                'activePostsCount'            => Post::active()->count(),
                'pendingPostsCount'           => Post::pending()->count(),
                'rejectedPostsCount'          => Post::rejected()->count(),
                'postCommentReportReadCount'  => PostCommentReport::read()->count()
            ]);
        });


        view()->composer('admin.components.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('read_status', 0)->count(),
            ]);
        });

        view()->composer('includes.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        // user dashboard
        view()->composer($activeTemplate . 'components.user.sidebar', function ($view) {
            $view->with([
                'categories'    => Category::where('status', 1)->with('posts')->get(),
                'user_notification'    => UserNotification::where('read_status', 0)->where('user_to',auth()->id())->with('posts')->count(),
                'policy_content' => getContent('policy_pages.content'),
                'policy_elements' =>  getContent('policy_pages.element'),
                'cookie_policy' =>  getContent('cookie.data')->first(),
            ]);
        });
        
        view()->composer($activeTemplate . 'components.sidenav', function ($view) {
            $view->with([
                'categories'    => Category::where('status', 1)->with('posts')->get(),
                'user_notification'    => UserNotification::where('read_status', 0)->where('user_to',auth()->id())->with('posts')->count(),
                'policy_content' => getContent('policy_pages.content'),
                'policy_elements' =>  getContent('policy_pages.element'),
                'cookie_policy' =>  getContent('cookie.data')->first(),
            ]);
        });



        view()->composer($activeTemplate . 'components.popular', function ($view) {
            $view->with([
                'popular_posts' => Post::where('status', 1)->with(['user', 'comments.user'])->orderBy('views', 'desc')->take(3)->get(),
            ]);
        });

        view()->composer($activeTemplate . 'components.community_state', function ($view) {

            $posts = Post::with('comments')->get();
            $total_replies = 0;
            foreach ($posts as $post) {
                $total_replies += $post->comments->count();
            }

            $view->with([
                'last_month_posts' => Post::whereMonth('created_at', now()->subMonth())->count(),
                'conversations' => Post::with('comments')->count(),
                'total_topic' => Category::count(),
                'total_replies' => $total_replies,
            ]);
        });

        view()->composer($activeTemplate . 'components.leftside', function ($view) {
            $view->with([
                'policy_content' => getContent('policy_pages.content'),
                'policy_elements' =>  getContent('policy_pages.element'),
                'cookie_policy' =>  getContent('cookie.data')->first(),
                'categories'    => Category::where('status', 1)->with('posts')->get(),
            ]);
        });

        view()->composer($activeTemplate . 'components.header', function ($view) {
            $view->with([
                'languages'  => Language::all(),
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();
    }
}
