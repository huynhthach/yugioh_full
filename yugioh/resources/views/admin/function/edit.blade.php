@extends('admin.layout.app')

@section('content')
<div class="container mt-4">
    <h2>Edit News</h2>

    <form method="post" action="{{ route('news.update', ['id' => $news->NewsID]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $news->Title }}" required>
        </div>

        <div class="form-group">
            <label for="news_image">News Image:</label>
            <input type="file" class="form-control-file" id="news_image" name="news_image" accept="image/*">
            @if ($news->image)
            <div class="form-group">
                <label>Current Image:</label>
                <img src="{{ asset('img/img_news/' . $news->image) }}" alt="" class="img-thumbnail" style="width: 50px; height: 50px;">
            </div>
            @endif
        </div>

        <div class="form-group">
            <label for="news_detail_image">News Detail Image:</label>
            <input type="file" class="form-control-file" id="news_detail_image" name="news_detail_image" accept="image/*">
            @if ($news->image)
            <div class="form-group">
                <label>Current Image:</label>
                @if(isset($news->details->ImagePath))
                <img src="{{ asset('img/img_news_detail/' . $news->details->ImagePath) }}" alt="" class="img-thumbnail" style="width: 50px; height: 50px;">
                @else
                @endif
            </div>
            @endif
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->CategoryID }}" {{ $news->CategoryID == $category->CategoryID ? 'selected' : '' }}>
                        {{ $category->CategoryName }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            @if(isset($news->details->Content))
            <textarea class="form-control" id="content" name="content" rows="5">{{ $news->details->Content }}</textarea>
            @else
            <textarea class="form-control" id="content" name="content" rows="5"></textarea>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update News</button>
    </form>
</div>
@endsection 