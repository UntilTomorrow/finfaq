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
                    @include('presets.default.components.leftside')
                    <!-- left side / -->
                    {{-- main content --}}
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 pt-60">
                                <div class="add-post global-card">
                                    <div class="tab-content">
                                        <div class="sign-up_box">
                                            <h3 class="title wow">@lang('Edit Post')</h3>
                                            <form method="POST" action="{{ route('user.post.update', $post->id) }}">
                                                @csrf
                                                <div class="row d-none">
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="form-group">
                                                            <input class="form--control d-none" hidden placeholder=""
                                                                name="post_type" value="job">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-group">
                                                            <input class="form--control" placeholder="" name="title"
                                                                value="{{ $post->title }}">
                                                            <label class="form--label">@lang('Title')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-group">
                                                            <input class="form--control" placeholder="" type="date"
                                                                name="deadline" value="{{ $post->deadline }}">
                                                            <label class="form--label">@lang('Deadline')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-group">
                                                            <input class="form--control" type="number" placeholder=""
                                                                name="vacancy" value="{{ @$post->vacancy }}">
                                                            <label class="form--label">@lang('Vacancy')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-group">
                                                            <input class="form--control" placeholder="" type="number"
                                                                name="salary" value="{{ $post->salary }}">
                                                            <label class="form--label">@lang('Salary Range')</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="form-group">
                                                            <textarea class="form--control trumEdit" placeholder="" name="content">{{ $post->content }}</textarea>
                                                            <label class="form--label">@lang('Description')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn--base w-50">@lang('post')</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- tab panel -->
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

@push('script')
    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>
@endpush
