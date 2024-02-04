@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title mb-5 d-inline">Update Categories</h5>
            <form method="POST" action="{{route('categories.update',$categories->id)}}" enctype="multipart/form-data">
                @csrf
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="name" value="{{$categories->name}}" id="form2Example1" class="form-control" placeholder="name" />
                </div>
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>
                @error('name')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </form>

            </div>
        </div>
    </div>
</div>
@endsection
