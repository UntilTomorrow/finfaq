<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header">
        <div class="container-fluid position-relative">
            <div class="row">
                <div class="header-wrapper">
                    <!-- ham menu -->
                    <i class="fa-sharp fa-solid fa-bars-staggered ham__menu" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"></i>

                    <!-- logo -->
                    <div class="header-menu-wrapper align-items-center d-flex">
                        <div class="logo-wrapper">
                            <a href="{{ route('home') }}" class="normal-logo" id="normal-logo"> <img
                                    src="{{ getImage('assets/images/general/logo.png') }}" alt=""></a>
                            <a href="{{ route('home') }}" class="dark-logo hidden" id="dark-logo"> <img
                                    src="{{ getImage('assets/images/general/logo_white.png') }}" alt=""></a>
                        </div>
                    </div>
                    <!-- / logo -->

                    <!-- Header Menu -->
                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            <li>
                                <div class="header-search-bar">
                                    <form id="header-search">
                                        <div class="header-search-input">
                                            <input type="text" placeholder=""
                                                class="header-form--control" onkeyup="search(this);">
                                        </div>
                                        <button class="header-search-btn">
                                            <span class="icon">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </span>
                                        </button>
                                    </form>
                                </div>
                                <div class="search-result-box d-none">

                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Header Menu /> -->
                    <!-- user actn -->
                    <div class="menu-right-wrapper">
                        @auth
                            <div class="avatar-thumb">
                                <a href="{{ route('user.home') }}"><img
                                        src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                                        alt="avatar"></a>
                            </div>
                        @endauth

                        <ul>
                            <li class="search-icon">
                                <a href="#" class="login-registration-list__link">
                                    <span class="icon search-icon">
                                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                    </span>
                                </a>
                            </li>
                            <!-- < dark option -->
                            <li class="dark-mood-option">
                                <div class="light-dark-btn-wrap ms-1" id="light-dark-checkbox1">
                                    <i class="las la-moon mon-icon"></i>
                                    <i class="las la-sun sun-icon "></i>
                                </div>
                            </li>
                            <!-- dark option /> -->
                            @guest
                                  <li class="login-registration-list login-icon">
                                <a href="{{ route('user.login') }}" class="login-registration-list__link">
                                    <span class="icon">
                                        <i class="las la-user-plus mt-1"></i>
                                    </span>
                                </a>
                            </li>
                            @endguest
                                
                            
                          

                            <li class="language-box">
                                <i class="fa-solid fa-globe"></i>
                                <div>
                                    <select class="select langSel">
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->code }}"
                                                @if (Session::get('lang') === $language->code) selected @endif>
                                                {{ __(ucfirst($language->code)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- user actn /> -->
                </div>

            </div>
        </div>
    </div>
</div>
<!--========================== Header section End ==========================-->
@push('script')
    <script>
        "use strict"

        function search(object) {
            var searchValue = $(object).val();
            var appendClass = $('.search-result-box');
            if (searchValue != '') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('post.search') }}",
                    data: {
                        search: searchValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {

                        if (data.data != '') {
                            var html = '';
                            $.each(data.data, function(key, item) {
                                html +=
                                    `<a href="{{ url('post-details/${item.id}') }}" class="search-result-list"
                                        aria-current="true">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="title">${item.title}</h6>
                                        </div>
                                        <p class="subtitle">${item.content.substring(0, 105)} .....</p>
                                    </a>`;
                            })
                            appendClass.removeClass('d-none').html(html);
                        } else {
                            var html =
                                `
                                    <div class="no-data">
                                        <p>No data found </p>
                                    </div>
                                `;
                            appendClass.removeClass('d-none').html(html);
                        }


                    },
                    error: function(data, status, error) {
                        $.each(data.responseJSON.errors, function(key,
                            item) {
                            Toast.fire({
                                icon: 'error',
                                title: item
                            })
                        });
                    }
                });
            } else {
                appendClass.addClass('d-none');
            }
            return false;
        }
    </script>
    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });
        });
    </script>
@endpush
