@extends('backend.layout.master')
@section('title','Shikhi | Edit Category')
@section('page','Category')

@section('page-content')

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit Categoty</h4>
            </div><!-- end card header -->

            <div class="card-body category-form">
                <form action="{{ route('category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="totalProjects" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="totalProjects" placeholder="Categoty Name" value="{{ $category->name }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="totalTasks" class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" id="totalTasks" placeholder="Categoty Slug" value="{{ $category->slug }}">
                                @error('slug')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack">
                                <button type="submit" class="btn btn-success">Update Categoty</button>
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
