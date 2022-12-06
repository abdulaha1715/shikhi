@extends('backend.layout.master')
@section('title','Shikhi | Create Course')
@section('page','Create Course')

@section('page-content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Create Course</h4>
                <a href="{{ route('course.index') }}">Back to Courses</a>
            </div><!-- end card header -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<form id="createform" action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title-input">Course Title</label>
                        <input type="text" class="form-control" name="name" id="title-input" value="" placeholder="Enter Course title" required="" />

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label>Description</label> <br>
                        <textarea name="description" id="description" cols="80" rows="8">
                            <h3>About Course</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

                            <br>

                            <h3 class="epih3">What Will You Learn?</h3>
                            <ul>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                            </ul>
                        </textarea>

                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body mb-3">
                    <div>
                        <label>Side Note</label> <br>
                        <textarea name="side_note" id="side_note" cols="80" rows="8">
                            <h3 class="epih3">Material Includes</h3>
                            <ul>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                            </ul>

                            <br>

                            <h3 class="epih3">Requirements</h3>
                            <ul>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                                <li>Lorem Ipsum is simply dummy text of the</li>
                            </ul>

                            <br>

                            <h3>Audience</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

                        </textarea>

                        @error('side_note')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Create</button>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Visibility</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-publish-status-input" class="form-label">Status</label>
                        <select class="form-select" name="status" id="choices-publish-status-input" class="formInput">
                            <option value="none">Select Status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Learner Level</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-learner-level-input" class="form-label">Level</label>
                        <select class="form-select" name="level" id="choices-learner-level-input" class="formInput">
                            <option value="none">Select Level</option>
                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate"  {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="expert"  {{ old('level') == 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"> Categories</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2"><a href="#" class="float-end text-decoration-underline">Add New</a>Select  category</p>
                    <select class="form-select" id="choices-category-input" name="category_id" data-choices="" data-choices-search-false="">
                        <option value="none">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thumbnail</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <input type="file" class="thumbnail-file filepond filepond-input-multiple" multiple name="thumbnail" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</form>

@endsection

@push('script')
<script>

    $('.thumbnail-file').filepond({
        storeAsFile: true,
        labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
        imagePreviewHeight: 170,
        imageCropAspectRatio: '1:1',
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        stylePanelLayout: 'compact',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom',
    });

    // tinymce
    tinymce.init({ selector: '#description', });
    tinymce.init({ selector: '#side_note', });
</script>
@endpush
