<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0; /* Remove default margin */
        }

        .sidebar {
            position: fixed;
            height: 100%;
            width: 200px;
            top: 0;
            left: 0;
            background-color: #f8f9fa; /* Bootstrap light background color */
            padding-top: 15px; /* Adjusted padding for fixed navbar */
        }

        .content {
            margin-left: 200px; /* Width of the sidebar */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <nav class="navbar navbar-expand-lg navbar-light flex-column">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('admin') }}">Admin Dashboard</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('users.index') }}">Quản Lý Người Dùng</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('database') }}">Quản Lý Tin Tức</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('comments.index') }}">Quản Lý Bình Luận</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('cards.index') }}">Quản Lý Thẻ</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('packs.index') }}">Quản Lý pack</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('reciept.index') }}">Quản Lý hoá đơn</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Content -->
            <div class="col-md-10 content">
                <div class="row">
                    <!-- User Info and Logout Button -->
                    <div class="col-md-12 bg-light">
                        @auth
                        <div class="text-right py-2 pr-4">
                            Xin chào, {{ Auth::user()->Username }}
                            <form action="{{ route('logout') }}" method="post" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary ml-2">Logout</button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
                <!-- Main Content -->
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
