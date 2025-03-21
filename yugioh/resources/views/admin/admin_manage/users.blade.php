<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        margin-right: 5px;
        text-decoration: none;
        background-color: #3498db;
        color: #fff;
        border-radius: 4px;
    }

    .btn-danger {
        background-color: #e74c3c;
    }

</style>
@extends('admin.layout.app')
@section('content')

<body>
    <div class="container">
        <h1>Quản lý người dùng</h1>
        <form action="{{ route('users.index') }}" method="GET" class="form-group">
            <input type="text" id="searchInput" name="keyword" placeholder="Tìm kiếm theo tên...">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->UserID }}</td>
                    <td>{{ $user->Username }}</td>
                    <td>{{ $user->Email }}</td>
                    <td>{{ $user->IDRole == 1 ? 'Khách hàng' : 'Admin' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->UserID) }}">Chỉnh sửa</a>
                        <form action="{{ route('users.destroy', $user->UserID) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xoá</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection