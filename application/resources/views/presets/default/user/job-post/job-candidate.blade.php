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
                        <div class="row justify-content-center gy-4 pt-80">
                            <div class="col-lg-12">
                                <div class="order-wrap mt-3">
                                    <div class="row justify-content-end">
                                        <div class="col-md-4 mb-3">
                                            <form>
                                                <div class="search-box w-100">
                                                    <input type="text" name="search" class="form--control"
                                                        value="{{ request()->search }}" placeholder="@lang('Search...')">
                                                    <button type="submit" class="search-box__button"><i
                                                            class="fas fa-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-wrap">
                                        <table class="table table--responsive--xl">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">@lang('Name')</th>
                                                    <th class="text-center">@lang('Expect Salary')</th>
                                                    <th class="text-center">@lang('Date')</th>
                                                    <th>@lang('Details')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($candidates as $candidate)
                                                    <tr>
                                                        <td class="text-center" data-label="Name">
                                                            {{ __($candidate->user?->fullname) }}</td>
                                                        <td data-label="Expect Salary">
                                                            {{ __($general->cur_sym) }}{{ showAmount($candidate->expect_salary) }}
                                                        </td>
                                                        <td data-label="Date">
                                                            {{ showDateTime($candidate->created_at) }}<br>{{ diffForHumans($candidate->created_at) }}
                                                        </td>
                                                        <td class="text-center" data-label="Details">
                                                            <a href="{{ route('user.profile.details', $candidate->user?->id) }}"
                                                                class="btn btn--sm mx-1">@lang('View')
                                                            </a>
                                                            <a href="{{ route('user.apply.job.download.file', $candidate->id) }}"
                                                                target="_blank" class="btn btn--sm">@lang('Download')
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center" data-label="Details">
                                                            {{ __($emptyMessage) }}</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row justify-content-end mt-3">
                                        <div class="col-md-3 mb-3">
                                            {{ $candidates->links() }}
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


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }
                modal.find('.userData').html(html);
                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);

        function downloadFile(object, event) {
            event.preventDefault();
            var id = $(object).data('id');
            var url = "{{ url('/') }}" + "/user/download-file/" + id;

            $.get(url, function(response, status) {
                if (status === "success") {
                    // The request was successful.

                } else {
                    // The request failed.
                    console.error(response);
                }
            });

        }
    </script>
@endpush
