<style>
            .search-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 40px;
        }

        .form-group {
            display: flex;
            align-items: center;
        }
</style>
<script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
@extends('layout.app')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
        <div class="search-container">
            <a href="{{ route('news.index', ['category' => '1', 'name' => request('name')]) }}" class="btn btn-secondary {{ request('category') == '1' ? 'active' : '' }}">tin tức</a>
            <a href="{{ route('news.index', ['category' => '2', 'name' => request('name')]) }}" class="btn btn-secondary {{ request('category') == '2' ? 'active' : '' }}">hướng dẫn</a>
        </div>
        @if ($newsList->count() <= 0)
            <h2>No news found</h2>
        @endif
            <h1 style="margin-top: 50px;margin-left: 55px;">Tin mới nhất</h1>
            <div id="news-container">
                @foreach($newsList as $news)
                <a href="{{ route('news.show', ['id' => $news->NewsID]) }}" class="blog-box row news-link card-link" data-card-id="{{ $news->NewsID }}">
                    <div class="col-md-4">
                        <div class="post-media">
                            @if ($news->image)
                            <img src="{{ asset('img/img_news/' . $news->image) }}" alt="" class="img-fluid">
                            <div class="hovereffect"></div>
                            @else
                            <p>No image available</p>
                            @endif
                        </div><!-- end media -->
                    </div><!-- end col -->

                    <div class="blog-meta big-meta col-md-8">
                        <h4>{{ $news->Title }}</h4>
                        <p>{{ $news->PublishedDate }}</p>
                    </div><!-- end meta -->
                </a><!-- end blog-box -->
                @endforeach
            </div>
        </div>

        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <div class="sidebar">
                <div class="widget">
                    <h2 class="widget-title">Video phổ biến</h2>
                    <div class="trend-videos">
                        <div class="blog-box">
                            <div class="post-media">
                                <a href="https://www.youtube.com/watch?v=-FhKHYy4a8w" class="video-play-button popup-youtube" title="">
                                    <img src="img/taka.jpg" alt="" class="img-fluid">
                                    <div class="hovereffect">
                                        <span class="videohover">
                                            <!-- Add play icon here -->
                                            <i class="fa fa-play-circle"></i>
                                        </span>
                                    </div><!-- end hover -->
                                </a>
                            </div><!-- end media -->
                            <div class="blog-meta">
                                <h4><a href="tech-single.html" title="">DUEL LINKS FINALS Duels: Takagi VS Yukoo </a></h4>
                            </div><!-- end meta -->
                        </div><!-- end blog-box -->

                        <hr class="invis">

                        <div class="blog-box">
                            <div class="post-media">
                                <a href="https://www.youtube.com/watch?v=83uHLJbp1y8" class="video-play-button popup-youtube" title="">
                                    <img src="img/blog/123.png" alt="" class="img-fluid">
                                    <div class="hovereffect">
                                        <span class="videohover">
                                            <!-- Add play icon here -->
                                            <i class="fa fa-play-circle"></i>
                                        </span>
                                    </div><!-- end hover -->
                                </a>
                            </div><!-- end media -->
                            <div class="blog-meta">
                                <h4><a href="tech-single.html" title="">Yu-Gi-Oh! World Championship 2023 TCG/OCG Final:Dragon Link vs Tenyi Swordsoul</a></h4>
                            </div><!-- end meta -->
                        </div>
                        <!-- end blog-box -->

                        <hr class="invis">
                    </div><!-- end videos -->
                </div><!-- end widget -->

                <div class="widget">
                    <h2 class="widget-title">Tin tức phổ biến</h2>
                    <div class="blog-list-widget">
                        <div class="list-group">
                            @php
                            // Lấy danh sách 3 tin tức ngẫu nhiên từ danh sách
                            $randomNewsList = $newsList->random(3);
                            @endphp

                            @foreach($randomNewsList as $news)
                            <a href="{{ route('news.show', ['id' => $news->NewsID]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="w-100 justify-content-between">
                                    @if ($news->image)
                                    <img src="{{ asset('img/img_news/' . $news->image) }}" alt="" class="img-fluid float-left">
                                    @else
                                    <p>No image available</p>
                                    @endif
                                    <h5 class="mb-1">{{ $news->Title }}</h5>
                                    <small>{{ $news->PublishedDate }}</small>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div><!-- end blog-list -->
                </div><!-- end widget -->
            </div><!-- end sidebar -->
        </div><!-- end col -->
    </div>
</section>
<script>
    $(document).ready(function() {
    $('.card-link').on('click', function(e) {
        e.preventDefault();

        var cardId = $(this).data('card-id');
        var url = '{{ route("incrementViewsNews", ["id" => ":cardId"]) }}';
        url = url.replace(':cardId', cardId);

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Thực hiện các thao tác sau khi tăng views thành công
                    console.log('Views incremented successfully');
                    window.location.href = '{{ route("news.show", ["id" => ":cardId"]) }}'.replace(':cardId', cardId);
                } else {
                    console.error('Error:', 'Failed to increment views');
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>
@endsection
