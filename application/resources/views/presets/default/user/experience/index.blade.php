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
                                <div class=" global-card">
                                    <div class="row justify-content-center mt-2">
                                        {{-- experience create --}}
                                        <h4 class="mb-3">@lang('Experience')</h4>
                                        <form action="{{ route('user.experience.store') }}" method="post">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control form--control"
                                                    id="create-recipient-name" name="title" placeholder="">
                                                <label class="form--label"
                                                    for="create-recipient-name">@lang('Title')</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control form--control"
                                                    id="create-company-name" name="company_name" placeholder="">
                                                <label class="form--label"
                                                    for="create-company-name">@lang('Company Name')</label>
                                            </div>

                                            <div class="form--check form-group mb-4">
                                                <input class="form-check-input" type="checkbox" value="on"
                                                    id="create-flexCheckDefault" name="curr_working"
                                                    onclick="checkbox(this)" checked>
                                                <label class="form-check-label" for="create-flexCheckDefault">
                                                    @lang('I am currently working in this company')
                                                </label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <input type="date" class="form-control form--control"
                                                    id="create-start-date" name="start_date">
                                                <label for="create-start-date" class="form--label">@lang('Start Date')</label>
                                            </div>

                                            <div class="form-group mb-4">
                                                <input type="date" class="form-control form--control"
                                                    id="create-end-date" name="end_date" readonly>
                                                <label for="create-end-date" class="form--label">@lang('End Date')</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control form--control"
                                                    id="create-location" name="location" placeholder="">
                                                <label for="create-location" class="form--label">@lang('Location')</label>
                                            </div>

                                            <div class="form-group mb-4">
                                                <textarea class="form-control form--control" placeholder="" id="create-message-text" name="responsibility"></textarea>
                                                <label for="create-message-text"
                                                    class="form--label">@lang('Responsibility')</label>
                                            </div>

                                            <div class="form-group text-end">
                                                <button type="submit"
                                                    class="btn btn-primary text-end">@lang('Save')</button>
                                            </div>
                                        </form>
                                    </div>
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
