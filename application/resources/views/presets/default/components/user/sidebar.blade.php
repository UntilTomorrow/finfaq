<!-- left side -->
<div class="col-lg-3">
    <aside class="leftside-bar">
        <!-- menu-item-wraper -->
        <div class="menu-item-wraper">
            <div class="nav-menu">
                <div class="navmenu-item-wraper">
                    <a href="{{ route('user.home') }}" class="menu-item">
                        <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
                        <h6 class="text {{ menuActive('user.home') }}">@lang('Dashboard')</h6>
                    </a>
                    
                    <a href="{{ route('user.notification.index') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-bell"></i></span>
                        <h6 class="text {{ menuActive('user.notification.index') }}">@lang('Notification')</h6>
                        @if ($user_notification > 0)
                            <span class="pulse">
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('user.price.plan.index') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-award"></i></span>
                        <h6 class="text {{ menuActive('user.price.plan.index') }}">@lang('Price Plan')</h6>
                    </a>

                    <a href="{{ route('user.refill.plan.index') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                        <h6 class="text {{ menuActive('user.refill.plan.index') }}">@lang('Refill Plan')</h6>
                    </a>

                    <a href="{{ route('user.post.job') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-toolbox"></i></span>
                        <h6 class="text {{ menuActive('user.post.job') }}">@lang('My Jobs')</h6>
                    </a>

                    <a href="{{ route('user.deposit.history') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-receipt"></i></span>
                        <h6 class="text {{ menuActive('user.deposit.history') }}">@lang('Deposit-Log')</h6>
                    </a>

                    <a href="{{ route('user.profile.setting') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                        <h6 class="text {{ menuActive('user.profile.setting') }}">@lang('Profile Setting')</h6>
                    </a>

                    <a href="{{ route('user.change.password') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-unlock-keyhole"></i></span>
                        <h6 class="text {{ menuActive('user.change.password') }}">@lang('Change Password')</h6>
                    </a>

                    <a href="{{ route('user.twofactor') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-signs-post"></i></span>
                        <h6 class="text {{ menuActive('user.twofactor') }}">@lang('2Fa Security')</h6>
                    </a>

                    <a href="{{ route('ticket') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-ticket"></i></span>
                        <h6 class="text {{ menuActive('ticket') }}">@lang('Support Ticket')</h6>
                    </a>

                    <a href="{{ route('user.logout') }}" class="menu-item">
                        <span class="icon"><i class="fa-solid fa-arrow-right-from-bracket text-danger"></i></span>
                        <h6 class="text {{ menuActive('user.logout') }}">@lang('Log Out')</h6>
                    </a>

                </div>
            </div>
            <!-- menu-item-wraper / -->

            <!-- latest-topics-menu -->
            <div class="latest-topics-menu">
                <div class="latest-topics-wraper">
                    <h6 class="menu-title">@lang('TOPICS')</h6>
                    <div class="latest-topics-list">
                        @foreach ($categories as $category)
                            @if ($loop->iteration > 0 && $loop->iteration <= 5)
                                <a href="{{ route('post.category', [slug($category->name), $category->id]) }}"
                                    class="menu-item">
                                    <span>
                                        @php echo  $category->icon ; @endphp
                                    </span>

                                    <h6 class="menu-name {{ (url()->current() == route('post.category', [slug($category->name), $category->id])) ? 'active' : '' }}">{{ $category->name }}</h6>
                                </a>
                            @endif
                            @if ($loop->iteration > 5)
                                <div class="show-all-menu-wraper">
                                    <div class="show-all-menu-item">
                                        <a href="{{ route('post.category', [slug($category->name), $category->id]) }}"
                                            class="menu-item">
                                            <span>
                                                @php echo  $category->icon ; @endphp
                                            </span>
                                            <h6 class="menu-name ">{{ $category->name }}</h6>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="menu-item">
                            <button class="show-all-tgl-btn">@lang('See More')</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- latest-topics-menu / -->

            <!-- others-menu -->
            <div class="others-menu">
                <div class="others-item-wraper">
                    <h6 class="menu-title">@lang('Others')</h6>
                    <div class="others-item-list">
                       
                        @if (@$cookie_policy->data_values?->status == 1)
                            <a href="{{ route('cookie.policy') }}" class="menu-item">
                                <span>
                                    @php echo  @$cookie_policy->data_values?->cookie_icon ; @endphp
                                </span>
                                <h6 class="menu-name {{ menuActive('cookie.policy') }}">@lang('Cookie')</h6>
                            </a>
                        @endif
                    </div>
                    @if (@$general->agree == 1)
                        @foreach ($policy_elements as $element)
                            <a href="{{ route('policy.pages', [slug($element->data_values?->title), $element->id]) }}"
                                class="menu-item">
                                <span>
                                    @php echo  @$element->data_values?->policy_icon ; @endphp
                                </span>
                                <h6 class="menu-name {{ (url()->current() == route('policy.pages', [slug($element->data_values?->title), $element->id])) ? 'active' : '' }}">{{ $element->data_values?->title }}</h6>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- others-menu /-->
            <!-- dark mode -->
            <div class="mode-option">
                <div class="mode-option-list">
                    <div class="menu-item">
                        <div class="light-dark-btn-wrap ms-1">
                            <i class="las la-moon mon-icon"></i>
                            <i class="las la-sun sun-icon"></i>
                        </div>
                        <h6 class="menu-name">@lang('Dark')</h6>
                    </div>
                    <div class="form--switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="light-dark-checkbox">
                    </div>
                </div>
            </div>
            <!-- dark mode /-->

            <div class="copy-right-text text-center ps-5 pb-5">
                <p class="bottom-footer-text"> &copy; @lang('Copyright') {{ now()->year }} @lang('. All rights reserved.') </p>
            </div>
        </div>
    </aside>
</div>
<!-- left side / -->

@push('style')
    <style>
        .pulse {

            display: block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: hsl(var(--base));
            cursor: pointer;
            box-shadow: 0 0 0 rgba(163, 185, 227, 0.4);
            animation: pulse 2s infinite;
        }

        .pulse:hover {
            animation: none;
        }

        @keyframes pulse {
            0% {
                -moz-box-shadow: 0 0 0 0 rgba(99, 106, 130, 0.4);
                box-shadow: 0 0 0 0 rgba(99, 106, 130, 0.4);
            }

            70% {
                -moz-box-shadow: 0 0 0 10px rgba(116, 122, 201, 0);
                box-shadow: 0 0 0 10px rgba(116, 122, 201, 0);
            }

            100% {
                -moz-box-shadow: 0 0 0 0 rgba(13, 2, 108, 0);
                box-shadow: 0 0 0 0 rgba(13, 2, 108, 0);
            }
        }
    </style>
@endpush
