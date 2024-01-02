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
                            <div class="col-xl-10 col-lg-12 pt-60">
                                <div class="edit-post global-card">
                                    <h3 class="title mb-4">@lang('Edit Post')</h3>
                                    <form method="POST" action="{{ route('user.post.update', $post->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row d-none">
                                            <div class="col-lg-12 mb-4">
                                                <div class="form-group">
                                                    <input class="form--control d-none" hidden placeholder=""
                                                        name="post_type" value="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 mb-4">
                                                <div class="form-group">
                                                    <input class="form--control" placeholder="" name="title"
                                                        value="{{ $post->title }}">
                                                    <label class="form--label">@lang('Title')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <select class=" select form-control form--control" name="category"
                                                        required="" id="category">
                                                        <option value="">@lang('Select Category')</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $category->id == $post->category_id ? 'selected' : '' }}>
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 mb-4">
                                                <p class="mb-2">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png') @lang('(max:') <strong>@lang('2MB)')</strong></p>
                                                <div class="form-group">
                                                    <input class="form--control" type="file" placeholder=""
                                                        name="images[]" accept=".png, .jpg, .jpeg" multiple>
                                                    <label class="form--label">@lang('Image')</label>
                                                </div>
                                            </div>
                                            @if ($post->images->count() > 0)
                                                <div class="col-lg-12 mb-4 d-flex">
                                                    <div class="row w-100">
                                                        @foreach ($post->images as $img)
                                                            <div class="col-xl-3 col-lg-6 image-card">
                                                                <div class="post-img-wrap">
                                                                    <div class="btn btn--sm btn--info detele-btn" onclick="imageDelete(this)" data-image-id ="{{$img->id}}"><i class="fa-solid fa-xmark"></i></div>
                                                                    <img src="{{ getImage(getFilePath('posts') . $img->path . $img?->image, getFileSize('posts')) }}" alt="image">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-4">
                                                <div class="form-group">
                                                    <textarea class="form--control trumEdit" placeholder="" name="content">{{ $post->content }}</textarea>
                                                    <label class="form--label">@lang('Description')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn--base w-50">@lang('Update')</button>
                                    </form>
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
    <script>
        function imageDelete(object) {
            var url = "{{ route('user.post.image') }}";
            var token = '{{ csrf_token() }}';
            var id = $(object).data("image-id");
            var data = {
                id: id,
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                   if (data.status == 'success') {
                    $(object).parent(".post-img-wrap").parent('.image-card').remove();
                    $(object).remove();
                   }
                },
                error: function(data, status, error) {
                    $.each(data.responseJSON.errors, function(key, item) {
                        Toast.fire({
                            icon: 'error',
                            title: item
                        })
                    });
                }
            });
        }
    </script>
@endpush
