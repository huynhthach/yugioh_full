@extends('admin.layout.app')

@section('content')
<div class="container mt-4">
    <h2>Create News</h2>

    <form method="post" action="{{ route('news.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="news_image">Image for News:</label>
            <input type="file" class="form-control-file" id="news_image" name="news_image" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <label for="news_detail_image">Image for NewsDetail:</label>
            <input type="file" class="form-control-file" id="news_detail_image" name="news_detail_image" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Create News</button>
    </form>
</div>
@endsection
