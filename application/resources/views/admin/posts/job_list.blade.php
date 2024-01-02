@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Applicant')</th>
                                    <th>@lang('Views')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.users.detail', $post->user->id) }}">{{ __(@$post->user?->fullname) }}
                                                ({{__(@$post->user?->username) }})
                                            </a>
                                        </td>

                                        <td>
                                            {{ __(@$post->title) }}
                                        </td>

                                        <td>
                                            {{ __(@$post->apply_job?->count()) }}
                                        </td>

                                        <td>
                                            {{ ($post->views) }}
                                        </td>

                                        <td>
                                            <a title="@lang('User Profile')" href="{{ route('post.details', $post->id) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-eye text--shadow"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($posts->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($posts) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <form action="" method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search by Username')"
                    value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

