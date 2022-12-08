@extends('backend.layout.master')
@section('title','Shikhi | Edit Lesson')
@section('page','Edit Lesson')

@section('page-content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit Lesson</h4>
                <a href="{{ route('course.index') }}">Back to Courses</a>
            </div><!-- end card header -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<form id="createform" action="{{ route('lesson.update', $lesson) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="lesson_title">Lesson Title</label>
                        <input type="text" class="form-control" name="lesson_title" id="lesson_title" value="{{ $lesson->name }}" placeholder="Enter Lesson title" required="" />

                        @error('lesson_title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label>Lesson Content</label> <br>
                        <textarea name="lesson_content" id="description" cols="80" rows="4">
                            {{ $lesson->content }}
                        </textarea>

                        @error('lesson_content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

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
                            <option value="public" {{ $lesson->status == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ $lesson->status == 'private' ? 'selected' : '' }}>Private</option>
                        </select>

                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            {{-- <div class="card d-none">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="l_youtube_id">Youtube Video ID</label>
                        <input type="text" class="form-control" name="l_youtube_id" id="title-input" value="{{ old('l_youtube_id') }}" placeholder="Enter Lesson title" required="" />

                        @error('l_youtube_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div> --}}
            <!-- end card -->

            <div class="card d-none">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="course_id">Lesson Title</label>
                        <input type="text" class="form-control" name="course_id" id="course_id" value="{{ $lesson->course_id }}" placeholder="Enter Lesson title" required="" />

                        @error('course_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</form>

@endsection

@push('script')
<script>
    // tinymce
    tinymce.init({ selector: '#description', });
</script>
@endpush
