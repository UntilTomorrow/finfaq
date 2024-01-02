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
                        <div class="row justify-content-center pt-80 gy-2">
                            <div class="col-xl-12">
                                <div class="row justify-content-center mt-2 px-3">
                                    @forelse ($pricePlan as $item)
                                        <div class="col-md-4 mb-4">
                                            <div class="card">
                                                <div class="card-header section-bg">
                                                    <strong>{{ucfirst(@$item->name)}}</strong>
                                                </div>
                                                <div class="card--body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            @lang('Price:') <strong>{{@$general->cur_sym}}{{@$item->price}}</strong>
                                                        </li>
                                                        <li class="list-group-item">
                                                            @lang('Credit:') <strong>{{@$item->credit}}</strong>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-footer create text-center">
                                                    <a href="{{route('user.price.plan.insert',@$item->id)}}" class="btn btn--base planPurchase"> 
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                        @lang('Purchase')
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="card-header section-bg">
                                            <strong>@lang('No data Found')</strong>
                                        </div>
                                    @endforelse
                                </div>

                            </div>
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
