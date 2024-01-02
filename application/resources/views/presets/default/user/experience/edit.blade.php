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
                                <div class="global-card">
                                    <div class="row justify-content-center mt-2">
                                        {{-- experience edit --}}
                                        <h4 class="mb-3">@lang('Experience')</h4>
                                        <form action="{{ route('user.experience.update',$experience->id) }}" method="post">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control form--control" id="recipient-name"
                                                    name="title" value="{{$experience->title}}">
                                                <label for="recipient-name" class="form--label">@lang('Title')</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control form--control" id="company-name"
                                                    name="company_name" value="{{$experience->company_name}}">
                                                <label for="company-name" class="form--label">@lang('Company Name')</label>
                                            </div>

                                            <div class="form-check form-group mb-4">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault" name="curr_working" onclick="checkbox(this)" @if($experience->currently_working == "on") checked @endif>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    @lang('I am currently working in this company')
                                                </label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <input type="date" class="form-control form--control" id="start-date"
                                                    name="start_date" value="{{$experience->start_date}}">
                                                <label for="start-date" class="form--label">@lang('Start Date')</label>
                                            </div>

                                            <div class="form-group mb-4">
                                                <input type="date" class="form-control form--control" id="end-date"
                                                    name="end_date" value="{{$experience->end_date}}" @if($experience->currently_working == "on") readonly @endif>
                                                <label for="end-date" class="form--label">@lang('End Date')</label>
                                            </div>

                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control form--control" id="location"
                                                    name="location" value="{{$experience->location}}">
                                                <label for="location" class="form--label">@lang('Location')</label>
                                            </div>

                                            <div class="form-group mb-4">
                                                <textarea class="form-control form--control" id="message-text" name="responsibility">@php echo $experience->responsibility; @endphp</textarea>
                                                <label for="message-text" class="form--label">@lang('Responsibility')</label>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">@lang('Update')</button>
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
