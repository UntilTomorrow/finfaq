@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section>
        <!-- header -->
        @include('presets.default.components.header')
        @include('presets.default.components.sidenav')

        <!-- body -->
        <div class="body-section">
            <div class="container-fluid">
                <div class="row m-0">
                    <!-- left side -->
                    @include('presets.default.components.user.sidebar')
                    <!-- left side / -->
                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row justify-content-center pt-80 px-3">
                            <div class="col-lg-10">
                                @forelse ($notifications as $notification)
                                    <div class="notification-card mb-3">
                                        <div class="notification-card__icon">
                                            <i class="fa-solid fa-bell"></i>
                                        </div>
                                        <div class="notification-box">
                                            <div class="notification-text">
                                                <h5 class="notification__title">{{ __($notification->type) }}</h5>
                                                <a href="{{ route('user.notification.read.status', $notification->id) }}"
                                                    class="notification-card__subtitle">{{ __($notification->title) }}</a>
                                            </div>
                                            <a href="{{ route('user.notification.read.status', $notification->id) }}"
                                                class="btn btn--sm mt-1"><i class="fa-solid fa-book-open"></i>
                                                @lang('Read')</a>
                                        </div>
                                    </div>

                                @empty
                                    <div class="col-lg-12 text-center">
                                        <div class="dashboard-card">
                                            <span class="banner-effect-1"></span>
                                            <div class="dashboard-card__icon">

                                            </div>
                                            <div class="dashboard-card__content notification-box">
                                                <div class="notification-text">
                                                    <h4 class="dashboard-card__amount">@lang('No Notifications')</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="mt-5 row justify-content-end mb-5">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                    {{-- main content / --}}
                    <!-- right side -->
                    <div class="col-lg-3">
                        <aside class="rightside-bar">
                            @include('presets.default.components.user_info')
                            @include('presets.default.components.popular')
                        </aside>
                    </div>
                    <!-- right side /-->
                </div>
            </div>
        </div>
    </section>
@endsection
