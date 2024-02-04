@extends('layouts.app')

@section('content')
<div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('{{asset('assets/images/background_pr.jpg')}}');">
    <div class="container">
    <div class="row same-height justify-content-center">
        <div class="col-md-6">
        <div class="post-entry text-center">
            <img src="{{asset('assets/images/'.$profile->image.'')}}" style="width:180px; border-radius:50%;">
            <h1 class="mb-4">{{$profile->name}}</h1>
            <div class="post-meta align-items-center text-center">
            <!--<figure class="author-figure mb-0 me-3 d-inline-block"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure>-->
            <span class="d-inline-block mt-1">{{$profile->user_name}}</span>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

<section class="section">
    <div class="container">

    <div class="row blog-entries element-animate">

        <div class="col-md-12 col-lg-8 main-content">

        <div class="post-content-body">
            <p>{{$profile->bio}}</p>
        </div>

        </div>

        <div class="col-md-12 col-lg-4 sidebar">
          <div class="sidebar-box p-3">
            <h3 class="heading">Latest Posts</h3>
            <div class="post-entry-sidebar">
              <ul>
                @foreach($latestPosts as $latestPost)
                <li>
                  <a href="{{route('posts.single',$latestPost->id)}}">
                    <img src="{{asset('assets/images/'.$latestPost->image.'')}}" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>{{$latestPost->title}}</h4>
                      <div class="post-meta">
                        <span class="mr-2">{{\Carbon\Carbon::parse($latestPost->created_at)->format('M d/Y')}}</span>
                      </div>
                    </div>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- Start posts-entry
  <section class="section posts-entry posts-entry-sm bg-light">
    <div class="container">
      <div class="row mb-4">
        <div class="col-12 text-uppercase text-black">More Blog Posts</div>
      </div>
      <div class="row">
        @if($moreBlogs->count() > 0)
        @foreach($moreBlogs as $blog)
        <div class="col-md-6 col-lg-3">
          <div class="blog-entry">
            <a href="{{route('posts.single',$blog->id)}}" class="img-link">
              <img src="{{asset('assets/images/'.$blog->image.'')}}" alt="Image" class="img-fluid">
            </a>
            <span class="date">{{\Carbon\Carbon::parse($blog->created_at)->format('M d/Y')}}</span>
            <h2><a href="single.html">{{$blog->title}}</a></h2>
            <p>{{$blog->description}}</p>
            <p><a href="{{route('posts.single',$blog->id)}}" class="read-more">Continue Reading</a></p>
          </div>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </section>--}}
@endsection
