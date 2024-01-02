{{-- post create --}}
<div class="modal fade" id="postExampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Post')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.post.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <div class="row d-none">
                            <input class="form--control d-none" hidden placeholder="" name="post_type" value="text">
                        </div>

                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class="form-control form--control" id="create-recipient-name"
                            name="title" placeholder="">
                        <label class="form--label" for="create-recipient-name">@lang('Title')</label>
                    </div>

                    <div class="form-group mb-4">
                        <select class="form-select form--control" name="category" required="" id="category">
                            <option value="">@lang('Select Category')</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mb-2">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png') @lang('(max:') <strong>@lang('2MB)')</strong></p>
                    <div class="form-group mb-4">
                        <input class="form--control" type="file" name="images[]" accept=".png, .jpg, .jpeg" multiple>
                        <label class="form--label">@lang('Image')</label>
                    </div>

                    <div class="form-group mb-4">
                        <textarea class="form--control trumEdit" placeholder="" name="content"></textarea>
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary text-end">@lang('Create')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- job post create --}}
<div class="modal fade" id="jobPostExampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Job Post')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.post.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <div class="row d-none">
                            <input class="form--control d-none" hidden placeholder="" name="post_type" value="job">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class="form-control form--control" id="create-recipient-title"
                            name="title" placeholder="">
                        <label class="form--label" for="create-recipient-title">@lang('Title')</label>
                    </div>

                    <div class="form-group mb-4">
                        <input class="form-control form--control" type="date" name="deadline">
                        <label class="form--label">@lang('Deadline')</label>
                    </div>

                    <div class="form-group mb-4">
                        <input class="form-control form--control" type="number" placeholder="" name="vacancy">
                        <label class="form--label">@lang('Vacancy')</label>
                    </div>

                    <div class="form-group mb-4">
                        <div class="form-group">
                            <input class="form--control" placeholder="" type="number" name="salary">
                            <label class="form--label">@lang('Salary Range')</label>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <textarea class="form--control trumEdit1" placeholder="" name="content"></textarea>
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary text-end">@lang('Create')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
