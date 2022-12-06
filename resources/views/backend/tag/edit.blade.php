@extends('backend.layout.master')
@section('title','Shikhi | Edit Tag')
@section('page','Tag')

@section('page-content')

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit Tag</h4>
            </div><!-- end card header -->

            <div class="card-body tag-form">
                <form action="{{ route('tag.update', $tag->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="totalProjects" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="totalProjects" placeholder="Tag Name" value="{{ $tag->name }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="totalTasks" class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" id="totalTasks" placeholder="Tag Slug" value="{{ $tag->slug }}">
                                @error('slug')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack">
                                <button type="submit" class="btn btn-success">Update Tag</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- end category-form -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

</div>
<!-- end row -->

@endsection
