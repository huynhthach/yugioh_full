<style>
    .text {
        padding-top: 80px;
    }

    .photo-frame {
        position: relative;
        max-width: 1000%;
        margin: 0px auto;
    }

    .overlay {
        font-size: 16px;
        left: 5%;
        line-height: 1;
        margin: 0px auto;
        padding: 0.6rem 1.5rem;
        position: absolute;
        text-align: center;
        top: -18px;
        z-index: 1;
    }

    .photo-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Center the images horizontally */
        gap: 30px; /* Khoảng cách giữa các ảnh */
        border: 2px dashed #fff; /* Đường viền đứt đoạn màu trắng */
        border-radius: 8px; /* Bo tròn góc */
        margin-bottom: 10px; /* Điều chỉnh khoảng cách dưới giữa các ảnh */
    }

    .photo-item {
        position: relative;
        width: 100%;
        max-width: 300px; /* Độ rộng tối đa cho ảnh nhỏ */
        overflow: hidden;
        border: 1px solid #ddd; /* Đường viền 1px màu xám */
        border-radius: 8px; /* Bo tròn góc */
        margin-bottom: 10px; /* Điều chỉnh khoảng cách dưới giữa các ảnh */
        transition: border 0.3s ease; /* Hiệu ứng chuyển động cho đường viền */
    }

    .photo-item:hover {
        border: 1px solid #555; /* Đường viền 1px màu đen khi rê chuột vào */
    }

    .photo-item img {
        width: 100%;
        height: auto;
        display: block;
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
    .favorite {
            color: pink;
            /* Màu hồng của bạn */
        }
</style>
<script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<div class="text">
    <div class="container mt-4">
        <div class="row">
            <div class="photo-frame">
                <div class="overlay">
                    <h2>My Desk</h2>
                </div>
                <div class="photo-container">
                    @foreach($catalogItems as $item)
                    <a href="#" class="card-link" data-toggle="modal" data-target="#cardModal{{ $item['ItemID'] }}">
                        <div class="photo-item">
                            <img src="{{ asset('img/item_img/' . $item['image']) }}" alt="">
                        </div>
                    </a>
                    <div class="modal fade custom-modal smaller-modal" id="cardModal{{ $item['ItemID'] }}" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel{{ $item['ItemID'] }}" aria-hidden="true">
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
                                            <img src="{{ asset('img/item_img/' . $item['image']) }}" class="img-fluid smaller-image" alt="{{ $item['ItemName'] }}">
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
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function() {
            $('.favorite-button').on('click', function() {

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

