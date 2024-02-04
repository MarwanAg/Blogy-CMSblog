@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-5">Edit Post</h3>
    <form action="{{route('posts.update',$single->id)}}" method="post" class="p-5 bg-light" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{$single->title}}" class="form-control" id="website">
        </div>
            @error('title')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$single->description}}</textarea>
        </div>
            @error('description')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div>
            <label for="category">Categories</label>
            <select name="category" class="form-select" aria-label="Default select example">
                <option selected>None</option>
                @foreach($categories as $category)
                    <option value="{{$category->name}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
            @error('category')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div class="form-group mt-2">
            <input type="submit" name="submit" value="Edit Post" class="btn btn-primary">
        </div>
    </form>
</div>
@endsection
