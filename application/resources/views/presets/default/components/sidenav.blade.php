<!--========================== Sidebar mobile menu wrap Start ==========================-->
<div class="offcanvas offcanvas-start text-bg-light" tabindex="-1" id="offcanvasExample">
    <div class="offcanvas-header">
        <div class="logo">
            <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="{{ route('home') }}" class="normal-logo" id="offcanvas-logo-normal"> <img
                            src="{{ getImage('assets/images/general/logo.png') }}" alt=""></a>
                    <a href="{{ route('home') }}" class="dark-logo hidden" id="offcanvas-logo-dark"> <img
                            src="{{ getImage('assets/images/general/dark-logo.png') }}" alt=""></a>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @auth
            <div class="user-info bg--color">
                <div class="user-thumb">
                    <a href="{{ route('user.home') }}">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                            alt="avatar">
                    </a>
                </div>
                <a href="{{ route('user.home') }}">
                    <h4>{{ auth()->user()->fullname }}</h4>
                </a>

            </div>
        @endauth
        <ul class="side-Nav">
            @guest
                <li>
                    <a class="active" href="{{ route('home') }}">
                        @lang('Home')
                    </a>
                </li>
            @endguest
            @auth
                <li>
                    <a href="{{ route('user.home') }}">

                        @lang('Dashboard')
                    </a>
                </li>
            @endauth

            <li>
                <a href="{{ route('post.popular') }}">
                    @lang('Popular')
                </a>
            </li>
            <li>
                <a href="{{ route('post.job') }}">
                    @lang('Jobs')
                </a>
            </li>

            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('post.category', [slug($category->name), $category->id]) }}">
                        {{ __($category->name) }}
                    </a>
                </li>
            @endforeach

            @auth
                <li>
                    <a href="{{ route('save.post') }}">

                        @lang('Bookmarks')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.notification.index') }}">

                        @lang('Notification')
                        @if ($user_notification > 0)
                            <span class="pulse">
                            </span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.price.plan.index') }}">

                        @lang('Pricing Plans')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.refill.plan.index') }}">
                        @lang('Refill Plan')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.post.job') }}">
                        @lang('My Jobs')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.deposit.history') }}">
                        @lang('Deposit-Log')
                    </a>
                </li>
                <li>
                    <a href="{{ route('ticket') }}">
                        @lang('Support Ticket')
                    </a>

                </li>
                <li>
                    <a href="{{ route('user.profile.setting') }}">
                        @lang('Profile Setting')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.change.password') }}">
                        @lang('Change Password')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.twofactor') }}">

                        @lang('2Fa Security')
                    </a>
                </li>
                
            @endauth
            @guest
                <li>
                    <a href="{{ route('user.login') }}">
                        @lang('Login')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.register') }}">
                        @lang('Signup')
                    </a>
                </li>

            @endguest
            @if (@$cookie_policy->data_values?->status == 1)
                <li>
                    <a href="{{ route('cookie.policy') }}">
                        @lang('Cookie')
                    </a>
                <li>
            @endif

            @if (@$general->agree == 1)
                @foreach ($policy_elements as $element)
                    <li>
                        <a href="{{ route('policy.pages', [slug($element->data_values?->title), $element->id]) }}">
                           {{__($element->data_values?->title)}}
                        </a>
                    </li>
                @endforeach
            @endif

            @auth
            <li>
                <a href="{{ route('user.logout') }}">
                    @lang('Log Out')
                </a>
            </li>
            @endauth
        </ul>
    </div>
</div>

<!--========================== Sidebar mobile menu wrap End ==========================-->
