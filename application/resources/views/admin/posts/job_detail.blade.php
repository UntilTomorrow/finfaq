@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-8">
            <div class="col-xl-12">
                <div class="row gy-2 pb-2 gx-2">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card prod-p-card background-pattern">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col-auto">
                                        <i class="dashboard-widget__icon las la-thumbs-up"></i>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0 text-end">{{ @$post->like }}
                                        </h3>
                                    </div>
                                    <p>@lang('Total likes of post') </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card prod-p-card background-pattern">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col-auto">
                                        <i class="dashboard-widget__icon las la-thumbs-down"></i>
                                    </div>
                                    <div class="col">

                                        <h3 class="m-b-0 text-end">{{ @$post->dislike }}
                                        </h3>
                                    </div>
                                    <p>@lang('Total dislikes of post') </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card prod-p-card background-pattern">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col-auto">
                                        <i class="dashboard-widget__icon las la-comment"></i>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0 text-end">{{ @$post->like }}
                                        </h3>
                                    </div>
                                    <p>@lang('Total comments of post') </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card prod-p-card background-pattern">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col-auto">
                                        <i class="dashboard-widget__icon las la-flag"></i>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0 text-end">{{ @$post->like }}
                                        </h3>
                                    </div>

                                    <p>@lang('Total reports of post') </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="row gy-2 pb-2 gx-2">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card p-2">
                            </div>
                            <div class="card-header">
                                <h5 class="card-title mb-0">@lang('User Information')</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3"><span class="navbar-user__thumb"><img
                                            src="{{ getImage('assets/images/user/profile' .$post->user?->image) }}"
                                            alt="image">
                                    </span>
                                </div>
                                <strong class="d-flex">@lang('User Name'):<h5>{{ __(@$post->user?->username) }}</h5></strong>
                                <strong class="d-flex">@lang('Email'):<h5>{{ @$post->user?->email }}</h5></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-9">
                        <div class="card">
                            <div class="card p-2">
                            </div>
                            <div class="card-header">
                                <h5 class="card-title mb-0">@lang('Post Information')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12 col-md-6 col-12 d-flex">
                                        <strong class="post-content text-xl-start">@lang('Title'):</strong>
                                        <h6 class="text-xl-start"> {{ __(' ' . $post->title) }}</h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-md-6 col-12 d-flex text-start">
                                        <strong class="post-content text-xl-start">@lang('Content'):</strong>
                                        <h6 class="text-xl-start"> @php echo  __(' ' . $post->content) ; @endphp</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="col-xl-12">
                <div class="row pb-2 gx-2">
                    <div class="col-sm-6 col-xl-12">
                        <div class="card">
                            <div class="card p-2">
                            </div>
                            <div class="card-header">
                                <h5 class="card-title mb-0">@lang('Recent Posts')</h5>
                            </div>
                            <div class="card-body">
                                <ul class="flex-wrap gap-3">
                                     @foreach ($latestPosts as $lpost)
                                    <li class="flex-grow-1 flex-shrink-0 mb-3">
                                        <a class="d-block" href="{{route('admin.posts.details',$lpost->id)}}">
                                            <h6>{{__(@$lpost->title)}}</h6>
                                            <p>{{__(strLimit(@$lpost->content,70))}}</p>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('style')
        <style>
            .post-content {
                padding-right: 18px;
                width: 18%;
            }
        </style>
    @endpush
