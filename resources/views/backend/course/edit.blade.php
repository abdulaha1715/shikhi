@extends('backend.layout.master')
@section('title','Shikhi | Edit Course')
@section('page','Edit Course')

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

<form id="createform" action="{{ route('course.update', $course) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title-input">Course Title</label>
                        <input type="text" class="form-control" name="name" id="title-input" value="{{ $course->name }}" placeholder="Enter Course title" required="" />

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label>Description</label> <br>
                        <textarea name="description" id="description" cols="80" rows="8">{{ $course->description }}</textarea>

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
                        <textarea name="side_note" id="side_note" cols="80" rows="8">{{ $course->side_note }}</textarea>

                        @error('side_note')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Update</button>
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
                            <option value="active" {{ $course->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $course->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
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
                            <option value="beginner" {{ $course->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ $course->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="expert" {{ $course->level == 'expert' ? 'selected' : '' }}>Expert</option>
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
                        <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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


<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Lessons</h4>
                <a href="{{ route('lesson.create') }}?course_id={{ $course->id }}">Create Lesson</a>
            </div><!-- end card header -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

<!-- end row -->
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card card-body">
            <label for="audience" class="form-label">Lessons</label>
            <div class="list-group col nested-list nested-sortable-handle sortable-lessons">

                @forelse ($course->lessons as $lesson)
                    <div class="list-group-item nested-2 cursor-pointer align-items-center d-flex">
                        <div class="drag align-items-center flex-grow-1">
                            <i class="ri-drag-move-fill align-bottom handle"></i> {{ $lesson->name }}
                        </div>
                        <div class="edit-icon align-items-center">
                            <a href="{{ route('lesson.edit', $lesson) }}"><i class="ri-edit-line fs-4 text-primary"></i></a>
                            <a href=""><i class="ri-eye-line fs-4 text-success"></i></a>
                            <form action="{{ route('lesson.destroy', $lesson->id) }}" method="POST" class="file-delete" onsubmit="return confirm('Do you want to delete?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class=""><i class="ri-delete-bin-5-line fs-4 text-danger"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center border rounded border-danger p-2 text-danger cursor-pointer">
                        No Lessons found yet!!!
                    </p>
                @endforelse

            <div class="card">
        </div><!-- end card-body -->
    </div>
</div>

@endsection


@php
// Laptop Image File size
if ( file_exists(public_path("storage/uploads/" . $course->thumbnail)) ) {
    $thumbnail_Size = \File::size(public_path("storage/uploads/" . $course->thumbnail));
} else {
    $thumbnail_Size = 1000;
}
@endphp

@push('script')
<script>
    FilePond.registerPlugin(
        FilePondPluginFileEncode,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageCrop,
        FilePondPluginImageExifOrientation,
        FilePondPluginImageResize,
        FilePondPluginImagePreview,
        FilePondPluginFilePoster,
        FilePondPluginImageEdit
    );

    FilePond.setOptions({
        instantUpload: false,
    });

    // mobile_thumbnail
    $('.thumbnail-file').filepond({
        storeAsFile: true,
        files: [{
            // the server file reference
            source: '{{ rand(15, 45454) }}',

            // set type to local to indicate an already uploaded file
            options: {
                type: 'local',

                // optional stub file information
                file: {
                    name: '{{ $course->thumbnail }}',
                    size: {{ $thumbnail_Size }},
                    type: 'image/png',
                },

                // pass poster property
                metadata: {
                    poster: '{{ asset('storage/uploads/' . $course->thumbnail) }}',
                },
            },
        }, ],
    });

    // tinymce
    tinymce.init({ selector: '#description', });
    tinymce.init({ selector: '#side_note', });
</script>
@endpush
