@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-5">Update Profile</h3>
            @if(\Session::has('update.user'))
            <div class="alert alert-success">
                <p>{!! \session::get('update.user') !!}</p>
            </div>
            @endif
    <form action="{{route('users.update',$user->id)}}" method="post" class="p-5 bg-light" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{$user->email}}" class="form-control">
        </div>
            @error('email')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{$user->name}}" class="form-control">
        </div>
            @error('name')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" cols="30" rows="10" class="form-control">{{$user->bio}}</textarea>
        </div>
            @error('bio')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        <div class="form-group mt-2">
            <input type="submit" name="submit" value="Save Changes" class="btn btn-primary">
        </div>
    </form>
</div>
@endsection
