@extends('backend.layout.master')
@section('title','Shikhi | Tag')
@section('page','Tag')

@section('page-content')

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Create Tag</h4>
            </div><!-- end card header -->

            <div class="card-body tag-form">
                <form action="{{ route('tag.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="totalProjects" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="totalProjects" placeholder="Tag Name" value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="totalTasks" class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" id="totalTasks" placeholder="Tag Slug" value="{{ old('slug') }}">
                                @error('slug')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack">
                                <button type="submit" class="btn btn-success">Add Tag</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- end category-form -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tag List</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                        <table class="table table-striped table-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($tags as $tag)
                                    <tr>
                                        <td class="fw-medium">{{ $tag->id }}</td>
                                        <td>{{ $tag->name }}</td>
                                        <td class="text-center">
                                            <div class="d-inline">
                                                <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-box-line align-bottom"></i></a>
                                                <form class="d-inline" action="{{ route('tag.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('Do you want to delete?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line align-middle"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="5" class="border py-6 text-center text-xl text-red-700">No Tag Found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection
