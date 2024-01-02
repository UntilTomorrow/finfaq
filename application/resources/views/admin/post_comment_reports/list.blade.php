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
                                    <th>@lang('Post Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Reason')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>
                                            {{ __(@$item->post?->title) }}
                                        </td>

                                        <td>
                                            {{ __(@$item->post?->category?->name) }}
                                        </td>

                                        <td>
                                            @if (@$item->type && @$item->type == 'post')
                                                @lang('Post')
                                            @else
                                                @lang('Comment')
                                            @endif
                                        </td>

                                        <td>
                                            <button title="@lang('Reason')" data-id="{{ $item->id }}"
                                                data-reason="{{ $item->reason }}" class="btn btn-sm btn--primary reason">
                                                <i class="las la-eye text--shadow"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <label class="switch m-0">
                                                <input type="checkbox" class="toggle-switch reportStatus"
                                                    data-id="{{ $item->id }}" name="status"
                                                    {{ $item->status ? 'checked' : null }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <a title="@lang('Post details')"
                                                href="{{ route('post.details', @$item?->post?->id) }}"
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
                @if ($data->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($data) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="reasonModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Reason')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <input type="hidden" name="act">
                <div class="modal-body">
                    <p class="reason-text"></p>
                </div>
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

@push('script')
    <script>
        (function($) {
            "use strict";
            $(".reason").on('click',function() {
                $('.reason-text').text($(this).data('reason'))
                $("#reasonModal").modal('show');
            });

        })(jQuery);

        $(document).ready(function() {
            "use strict";
            $(".reportStatus").on('click',function() {
                var url = "{{ route('admin.post.comment.status') }}";
                var token = '{{ csrf_token() }}';
                var data = {
                    id: $(this).data("id"),
                    _token: token
                }
                $.post(url, data, function(data, status) {
                    if (data.status == "success") {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    }
                });
            });

        });
    </script>
@endpush
