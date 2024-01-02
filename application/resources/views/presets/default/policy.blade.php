@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section>
        @include('presets.default.components.header')
        @include('presets.default.components.sidenav')

        <!-- body -->
        <div class="body-section">
            <div class="container-fluid">
                <div class="row m-0">
                    <!-- left side -->
                    @include('presets.default.components.leftside')
                    <!-- left side / -->
                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="privacy pt-60">
                                    <div class="single-terms wyg mb-30 px-3">
                                        <h4 class="mb-3">{{ $policy->data_values->title }}</h4>
                                        <div>
                                            @php
                                                echo $policy->data_values->details;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- main content / --}}
                    <!-- right side -->
                    <div class="col-lg-3">
                        <aside class="rightside-bar">
                            @include('presets.default.components.community_state')
                            @include('presets.default.components.popular')
                        </aside>
                    </div>
                    <!-- right side /-->

                </div>
            </div>
        </div>
    </section>
@endsection
