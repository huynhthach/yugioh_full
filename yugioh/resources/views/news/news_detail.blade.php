<style>
    .text {
        padding-top: 50px;
    }

    .comment {
        padding: 10px;
    }

    .comment p {
        margin-bottom: 5px;
    }

    .comment p.posted-by {
        font-style: italic;
        color: #6c757d;
    }

    .comments {
    margin: 0 200px;
    padding: 5px;
    border: 1px solid #ced4da;
    }
    
    .comment-form{
        margin: 0 200px;
    }
</style>
@extends('layout.app')
@section('content')
<section class="section">
    <div class="text">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h1>{{ $news->Title }}</h1>
                    <p>{{ $news->PublishedDate }}</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="post-media">
                    @if ($news->details)
                    <img src="{{ asset('img/img_news_detail/' .$news->details->ImagePath) }}" alt="{{ $news->Title }}" class="img-fluid mx-auto d-block" style="max-width: 300px;">
                    @else
                    <p>No image available</p>
                    @endif
                </div><!-- end media -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="blog-content">
                    @if ($news->details)
                    <p class="mb-0">{{ $news->details->Content }}</p>
                    @else
                    <p>No content available</p>
                    @endif
                </div><!-- end content -->
            </div><!-- end col -->
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="comments">
                    <h3>Comments</h3>
                    <ul class="list-unstyled">
                        @foreach($news->comments as $comment)
                        <li>
                            <div class="comment">
                                <p>{{ $comment->Content }}</p>
                                <p>Posted by: {{ $comment->users->Username }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div><!-- end comments -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="comment-form">
                    @auth <!-- Kiểm tra xem người dùng đã đăng nhập hay chưa -->
                    <form action="{{ route('comment.save', $news->NewsID) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="content" rows="3" placeholder="Your comment" style="color: white;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @else
                    <p>Please <a href="{{ route('login') }}">log in</a> to leave a comment.</p>
                    @endauth
                </div><!-- end comment-form -->
            </div><!-- end col -->
        </div><!-- end row -->
        <!-- Hiển thị danh sách các comment -->
    </div>
</section>
@endsection