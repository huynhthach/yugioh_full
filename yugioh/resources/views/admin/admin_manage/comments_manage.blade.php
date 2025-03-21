@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1>Danh sách Comment</h1>

    <!-- Form tìm kiếm -->
    <form action="{{ route('comments.index') }}" method="GET" class="form-inline mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm bình luận...">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Mã bình luận</th>
                <th>Tên người dùng</th>
                <th>Bài viết được bình luận</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
            <tr>
                <td>{{ $comment->Comment_ID }}</td>
                <td>{{ $comment->users->Username }}</td>
                <td>{{ $comment->news->Title }}</td>
                <td>{{ $comment->Content }}</td>
                <td>{{ $comment->Created_at }}</td>
                <td>
                    <form action="{{ route('comments.destroy', $comment->Comment_ID) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
