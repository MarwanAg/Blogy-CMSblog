@extends('layouts.app')

@section('content')
<div class="section search-result-wrap">
		<div class="container">
			{{--<div class="row">
				<div class="col-12">
					<div class="heading">Category: {{$name}}</div>
				</div>
			</div>--}}
			<div class="row posts-entry">
				<div class="col-lg-8">
                    @foreach($results as $result)
					<div class="blog-entry d-flex blog-entry-search-item">
						<a href="{{route('posts.single',$result->id)}}" class="img-link me-4">
							<img src="{{asset('assets/images/'.$result->image.'')}}" alt="Image" class="img-fluid">
						</a>
						<div>
							<span class="date">{{\Carbon\Carbon::parse($result->created_at)->format('M d/Y')}} &bullet; <a href="#">Business</a></span>
							<h2><a href="{{route('posts.single',$result->id)}}">{{$result->title}}</a></h2>
							<p>{{substr($result->description,0,225)}}</p>
							<p><a href="{{route('posts.single',$result->id)}}" class="btn btn-sm btn-outline-primary">Read More</a></p>
						</div>
					</div>
                    @endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
