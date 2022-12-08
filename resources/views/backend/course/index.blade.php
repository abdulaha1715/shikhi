@extends('backend.layout.master')
@section('title', 'Shikhi | Course')
@section('page', 'Course')

@section('page-content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Course List</h4>
                    <a href="{{ route('course.create') }}">Add Course</a>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Category</th>
                                    <th class="text-center" scope="col">Lessons</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $course)
                                    <tr>
                                        <td class="fw-medium">{{ $course->id }}</td>
                                        <td>
                                            @php
                                                if ( !empty($course->thumbnail)) {
                                                    $course_image = $course->thumbnail;
                                                } else {
                                                    $course_image = asset('./backend/assets/images/users/user-dummy-img.jpg');
                                                }
                                            @endphp
                                            <img class="user-image" src="{{ $course_image }}" alt="" srcset="">
                                        </td>
                                        <td>{{ $course->name }}</td>
                                        <td class="text-capitalize text-center">{{ $course->status }}</td>
                                        <td class="text-center">{{ $course->category->name }}</td>
                                        <td class="text-center">
                                            @if (count($course->lessons) > 0)
                                            <button class="btn btn-primary position-relative p-0 avatar-xs rounded">
                                                <span
                                                    class="avatar-title bg-transparent text-reset">
                                                    {{ count($course->lessons) }}
                                                </span>
                                            </button>
                                        @else

                                            <button class="btn text-white bg-danger position-relative p-0 avatar-xs rounded">
                                                <span
                                                    class="avatar-title bg-transparent text-reset">
                                                    {{ count($course->lessons) }}
                                                </span>
                                            </button>
                                            <span
                                                class="badge bg-danger">
                                                {{ count($course->lessons) }}
                                            </span>
                                        @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('course.edit', $course) }}"><i class="ri-edit-line fs-4 text-primary"></i></a>
                                            <a href=""><i class="ri-eye-line fs-4 text-success"></i></a>
                                            <form action="{{ route('course.destroy', $course->id) }}" method="POST" class="file-delete" onsubmit="return confirm('Do you want to delete?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=""><i class="ri-delete-bin-5-line fs-4 text-danger"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="fs-5 text-center">
                                            No records are found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div><!-- end card-body -->
                <div class="pagination ">
                    {{ $courses->links() }}
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection
