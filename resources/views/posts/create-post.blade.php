@extends('layouts.app')
@section('content')
<div class="container">
    <h3 class="mb-5">Create New Post</h3>
    @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{!! \session::get('success') !!}</p>
        </div>
    @endif

    <form action="{{route('posts.store')}}" method="post" class="p-5 bg-light" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="website">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div>
            <label for="category">Categories</label>
            <select name="category" class="form-select" aria-label="Default select example">
                <option selected>None</option>
                @foreach($categories as $category)
                    <option value="{{$category->name}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Image</label>
            <input type="file" name="image" class="form-control" id="website">
        </div>
        <div class="form-group mt-2">
            <input type="submit" name="submit" value="Create Post" class="btn btn-primary">
        </div>
    </form>
</div>
@endsection
