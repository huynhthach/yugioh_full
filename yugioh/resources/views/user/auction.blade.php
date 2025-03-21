    <style>
            .text {
            padding-top: 120px;
        }
        .card-header{
            color: white;
        }
    </style>

    @extends('layout.app')

    @section('content')
    <div class="text">
        <div class="container">
        <a href="{{ route('user.Create.auction') }}" class="btn btn-success">Create Packs</a>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Danh sách sản phẩm đang được đấu giá</div>

                        <div class="card-body">
                            <div class="row">
                                @foreach ($auctions as $auction)
                                @foreach ($auction->recieptdetail as $detail)
                                @if ($detail->item)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        @if ($detail->item->image)
                                        <img class="card-img-top" src="{{ asset('img/item_img/' . $detail->item->image) }}" alt="{{ $detail->item->ItemName }}">
                                        @else
                                        <img class="card-img-top" src="{{ asset('img/placeholder.jpg') }}" alt="Placeholder">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $detail->item->ItemName }}</h5>
                                            <p class="card-text">Giá hiện tại: {{ $auction->TotalAmount }}</p>
                                            <p class="card-text">Số lượng: {{ $detail->Quantity }}</p>
                                            <div class="auction-item" data-start-time="{{ $auction->RecieptDate }}">
                                                <p class="card-text">Thời gian còn lại: <span class="time-remaining"></span></p>
                                            </div>
                                            @if(Auth::user()->UserID !== $auction->UserIDSell)
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bidModal{{ $auction->RecieptID }}">Đấu giá</button>
                                            @else
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bidErrorModal{{ $auction->RecieptID }}">Đấu giá</button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="bidModal{{ $auction->RecieptID }}" tabindex="-1" role="dialog" aria-labelledby="bidModalLabel{{ $auction->RecieptID }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bidModalLabel{{ $auction->RecieptID }}">Đấu giá</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('user.bid.auction', $auction->RecieptID) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $detail->item->id }}">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="bidAmount">Nhập số tiền đấu giá:</label>
                                                        <input type="number" class="form-control" id="bidAmount" name="bidAmount" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Đấu giá</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Error -->
                                <div class="modal fade" id="bidErrorModal{{ $auction->RecieptID }}" tabindex="-1" role="dialog" aria-labelledby="bidErrorModalLabel{{ $auction->RecieptID }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bidErrorModalLabel{{ $auction->RecieptID }}">Lỗi đấu giá</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn không thể đấu giá trên sản phẩm của chính mình.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endif

                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateRemainingTime() {
                $('.auction-item').each(function() {    
                    var $auctionItem = $(this); // Lưu tham chiếu của phần tử HTML hiện tại
                    var startTime = new Date($auctionItem.data('start-time')).getTime() / 1000; // Chuyển đổi endTime sang timestamp (đơn vị giây)
                    var endTime = startTime + 10;
                    var now = Math.floor(Date.now() / 1000);
                    var timeRemaining = endTime - now;
                    if (now < endTime) {
                        var minutes = Math.floor(timeRemaining / 60);
                        var seconds = timeRemaining % 60;
                        $auctionItem.find('.time-remaining').text(minutes + ' phút ' + seconds + ' giây');
                    } else {
                        $auctionItem.find('.time-remaining').text('Thời gian đã hết');
                        // Tắt button đấu giá khi hết thời gian
                        $auctionItem.closest('.card-body').find('.btn.btn-primary').prop('disabled', true);
                    }
                    
                });
            }

            // Cập nhật lại thời gian còn lại sau mỗi giây
            setInterval(updateRemainingTime, 1000);

            // Gửi yêu cầu AJAX sau mỗi 10 giây để cập nhật dữ liệu đấu giá
            setInterval(function() {
                $.ajax({
                    url: '{{ route("user.auction") }}',
                    method: 'GET',
                    success: function(response) {
                        // Cập nhật dữ liệu đấu giá và thời gian còn lại
                        // response chứa dữ liệu mới từ máy chủ
                        // Sau đó, gọi lại hàm updateRemainingTime()
                        updateRemainingTime();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }, 10000); // 10 giây
        });
    </script>