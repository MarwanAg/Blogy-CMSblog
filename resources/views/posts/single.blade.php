@extends('layouts.app')
@section('content')
<div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('{{asset('assets/images/'.$single->image.'')}}');">
    <div class="container">
    <div class="row same-height justify-content-center">
        @if(\Session::has('update'))
            <div class="alert alert-success">
                <p>{!! is_array(\session::get('update')) ? implode('<br>', \session::get('update')) : \session::get('update') !!}</p>
            </div>
        @endif
        <div class="col-md-6">
        <div class="post-entry text-center">
            <h1 class="mb-4">{{$single->title}}</h1>
            <div class="post-meta align-items-center text-center">
            <!--<figure class="author-figure mb-0 me-3 d-inline-block"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure>-->
            <span class="d-inline-block mt-1">{{$single->user_name}}</span>
            <span>&nbsp;-&nbsp; {{\Carbon\Carbon::parse($single->created_at)->format('M d/Y')}}</span>
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
            <p>{{$single->description}}</p>
        </div>


        <div class="pt-5">
            <p>Categories: <a href="{{route('category.single',$single->category)}}">{{$single->category}}</a></p>
        </div>

        @auth
            @if(Auth::user()->id == $single->user_id)
                <a type="button" class="btn btn-danger" href="{{ route('posts.delete',$single->id) }}" role="button">Delete</a>
            @endif
        @endauth
        @auth
            @if(Auth::user()->id == $single->user_id)
                <a type="button" class="btn btn-warning text-white" href="{{ route('posts.edit',$single->id) }}" role="button">Update</a>
            @endif
        @endauth

        @if(\Session::has('success'))
            <div class="alert alert-success">
                <p>{!! \session::get('success') !!}</p>
            </div>
        @endif

        <div class="pt-5 comment-wrap">
            <h3 class="mb-5 heading">{{$commentNum}} Comments</h3>
            <ul class="comment-list">
            @foreach($comments as $comment)
            <li class="comment">
                <!--<div class="vcard">
                <img src="images/person_1.jpg" alt="Image placeholder">
                </div>-->
                <div class="comment-body">
                <h3>{{$comment->user_name}}</h3>
                <div class="meta">{{\Carbon\Carbon::parse($comment->created_at)->format('M d/Y')}}</div>
                <p>{{$comment->comment}}</p>
                <!--<p><a href="#" class="reply rounded">Reply</a></p>-->
                </div>
            </li>
            @endforeach
            </ul>
            <!-- END comment-list -->

            <div class="comment-form-wrap pt-5">
            <h3 class="mb-5">Leave a comment</h3>
            <form action="{{route('comment.store')}}" method="post" class="p-5 bg-light">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="post_id" value="{{$single->id}}" class="form-control" id="website">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="comment" id="message" cols="30" rows="10" class="form-control"></textarea>
                </div>
                @auth
                <div class="form-group">
                    <input type="submit" name="submit" value="Post Comment" class="btn btn-primary">
                </div>
                @endauth
            </form>
            </div>
        </div>

        </div>

        <!-- END main-content -->

        <div class="col-md-12 col-lg-4 sidebar">

          <!-- END sidebar-box -->
          <div class="sidebar-box p-2">
            <div class="bio text-center">
              <img src="{{asset('assets/user_images/'.$user->image.'')}}" alt="Image Placeholder" class="img-fluid mb-3">
              <div class="bio-body">
                <h2>{{$user->name}}</h2>
                <p class="mb-4">{{$user->bio}}</p>
                <p><a href="{{route('users.profile',$user->id)}}" class="btn btn-primary btn-sm rounded px-2 py-2">Read my bio</a></p>
                <p class="social">
                  <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                </p>
              </div>
            </div>
          </div>
          <!-- END sidebar-box -->
          <div class="sidebar-box p-3">
            <h3 class="heading">Popular Posts</h3>
            <div class="post-entry-sidebar">
              <ul>
                @foreach($popPosts as $post)
                <li>
                  <a href="{{route('posts.single',$post->id)}}">
                    <img src="{{asset('assets/images/'.$post->image.'')}}" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>{{$post->title}}</h4>
                      <div class="post-meta">
                        <span class="mr-2">{{\Carbon\Carbon::parse($post->created_at)->format('M d/Y')}}</span>
                      </div>
                    </div>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <!-- END sidebar-box -->

          <div class="sidebar-box p-3">
            <h3 class="heading">Categories</h3>
            <ul class="categories">
            @foreach($categories as $category)
                <li><a href="#">{{$category->name}} <span>{{$category->total}}</span></a></li>
            @endforeach
            </ul>
          </div>
          <!-- END sidebar-box -->


        </div>
        <!-- END sidebar -->

      </div>
    </div>
  </section>


  <!-- Start posts-entry -->
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
            <p>{{substr($blog->description,0,200)}}</p>
            <p><a href="{{route('posts.single',$blog->id)}}" class="read-more">Continue Reading</a></p>
          </div>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </section>
@endsection
