<!-- resources/views/yugioh/cardinfo.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yugioh Card Info</title>
    <link>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            width: 100%;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #dee2e6;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .small {
            font-size: 0.875rem;
        }

        .pagination {
            margin-top: 20px;
            width: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination a {
            text-decoration: none;
            padding: 10px;
            margin: 5px;
            border: 1px solid #007bff;
            color: #007bff;
            border-radius: 5px;
        }

        .pagination .active {
            background-color: #007bff;
            color: #fff;
        }

        .text {
            padding-top: 80px;
            background-image: url("../img/body_bg.png");
        }

        .search-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group {
            display: flex;
            align-items: center;
        }

        .form-group label {
            margin-right: 10px;
        }

        .form-group .btn-primary {
            margin-left: 3px;
        }

        .name {
            color: white;
        }

        /* Style for the search result message */
        .search-result {
            margin-top: 10px;
            /* Add space above the result message */
            font-style: italic;
            /* Optionally, make the result message italic */
        }

        .favorite {
            color: pink;
            /* Màu hồng của bạn */
        }

        .custom-modal.smaller-modal .modal-dialog {
            max-width: 50%;
            max-height: 50%;
        }

        .custom-modal.smaller-modal .modal-content {
            width: 70%;
            max-height: 50%;
            margin: 0px auto;
        }

        .custom-modal.smaller-modal .modal-body .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .modal-description {
            max-height: 330px;
            /* Đặt giá trị tùy thuộc vào chiều cao tối đa bạn muốn */
            overflow-y: auto;
            color: white;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
</head>

<body>
    @extends('layout.app')

    @section('content')
    <div class="text">
        <div class="container mt-4">
            <h1 class="mb-4">Yugioh Desk</h1>

            <div class="row">
                @foreach ($items as $row)
                @foreach ($row as $item)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <a href="#" class="card-link" data-card-id="{{ $item['ItemID'] }}" data-toggle="modal" data-target="#cardModal{{ $item['ItemID'] }}">
                            @if ($item['image'])
                            <img src="{{ asset('img/item_img/' . $item['image']) }}" class="card-img-top" alt="{{ $item['ItemName'] }}">
                            @else
                            <div class="context">
                                <p>No image available</p>
                            </div>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Modal for each item -->
                <div class="modal fade custom-modal smaller-modal" id="cardModal{{ $item->ItemID }}" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel{{ $item->ItemID }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <button class="favorite-button" data-item-id="{{ $item->ItemID }}" data-favorite="{{ $item->isFavoritedByUser(auth()->id()) ? 'true' : 'false' }}">
                                        <i class="fas fa-heart {{ $item->isFavoritedByUser(auth()->id()) ? 'favorite' : '' }}"></i>
                                    </button>
                                    {{ $item->ItemName }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Display image in modal -->
                                        @if ($item->image)
                                        <img src="{{ asset('img/item_img/' . $item->image) }}" class="img-fluid smaller-image" alt="{{ $item->ItemName }}">
                                        @else
                                        <p>No image available</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Display name and description in modal -->
                                        <div class="modal-description">
                                            <p><strong>Name:</strong> {{ $item->ItemName }}</p>
                                            <p><strong>Description:</strong></p>
                                            {{ $item->Description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>

            <div class="pagination mt-4">
                @php
                $maxPages = 10;
                $halfMax = (int) ($maxPages / 2);
                $startPage = max(1, min($totalPages - $maxPages + 1, $currentPage - $halfMax));
                $endPage = min($totalPages, $startPage + $maxPages - 1);
                @endphp

                @if ($currentPage <= $totalPages) @if ($startPage> 1 && $endPage > $startPage)
                    <a href="{{ route('cardset', ['page' => 1]) }}">1</a>
                    <span>...</span>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++) <a href="{{ route('cardinfo', ['page' => $i]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if ($endPage < $totalPages && $endPage> $startPage)
                            <span>...</span>
                            <a href="{{ route('cardinfo', ['page' => $totalPages]) }}">{{ $totalPages }}</a>
                            @endif
                            @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.card-link').on('click', function(e) {
                e.preventDefault();

                var cardId = $(this).data('card-id');
                var url = '{{ route("incrementViews", ["id" => ":cardId"]) }}';
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

        $(document).ready(function() {
            $('.favorite-button').on('click', function() {
                var isAuthenticated = '{!! auth()->check() ? true : false !!}';

                if (!isAuthenticated) {
                    // Chuyển người dùng đến trang đăng nhập nếu chưa đăng nhập
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                var itemId = $(this).data('item-id');
                var isFavorite = $(this).data('favorite');

                // Gửi AJAX request để cập nhật trạng thái Favorite
                $.ajax({
                    type: 'POST',
                    url: "{{ route('toggle.favorite') }}",
                    data: {
                        item_id: itemId,
                        is_favorite: !isFavorite,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        if (data.success) {
                            // Cập nhật trạng thái của icon và dữ liệu
                            $('.favorite-icon[data-item-id="' + itemId + '"]').data('favorite', !isFavorite);

                            // Nếu item đã có trong owner items, chuyển trái tim thành màu hồng
                            if (data.isFavoritedByUser) {
                                // Thêm class 'favorite' để thay đổi màu sắc
                                $('.favorite-button[data-item-id="' + itemId + '"] i').addClass('favorite');
                                console.log($('.favorite-button[data-item-id="' + itemId + '"] i'));
                            } else {
                                // Nếu item chưa có trong owner items, xoá class 'favorite'
                                $('.favorite-button[data-item-id="' + itemId + '"] i').removeClass('favorite');
                                // Thực hiện các thao tác khác nếu cần
                            }
                        } else {
                            console.error('Error:', 'Toggle favorite request failed');
                        }
                    },
                });
            });
        });
    </script>
</body>

</html>