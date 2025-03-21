<style>
    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .pagination a {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 5px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
    }

    .pagination a.active {
        background-color: #007bff;
        color: #fff;
    }
</style>

@extends('admin.layout.app')
@section('content')
<div class="container mt-4">
    <h1>Quản lý tin tức</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('news.create') }}" class="btn btn-primary">Thêm tin tức</a>
        <form action="{{ route('database') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" id="searchInput" name="search_name" class="form-control" placeholder="Tìm kiếm theo tên...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>

    @foreach($db as $row)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $row->Title }}</h5>
            <p class="card-text">
                <strong>Ngày đăng:</strong> {{ $row->PublishedDate }}<br>
                <strong>Loại tin tức:</strong> {{ $row->CategoryName }}
            </p>
            <a href="{{ route('news.edit', ['id' => $row->NewsID]) }}" class="btn btn-primary">Sửa</a>
            <form method="post" action="{{ route('news.delete', ['id' => $row->NewsID]) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Xóa</button>
            </form>
        </div>
    </div>
    @endforeach
    <!-- Hiển thị liên kết phân trang -->
    @if($totalPages > 1)
    <div class="pagination">
        @for ($i = 1; $i <= $totalPages; $i++) <a href="{{ route('database', ['page' => $i]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
            @endfor
    </div>
    @endif
</div>

@endsection
</body>

</html>