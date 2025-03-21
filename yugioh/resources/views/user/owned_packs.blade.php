<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Thêm modal vào trang của bạn -->
<div class="modal fade" id="gachaModal" tabindex="-1" role="dialog" aria-labelledby="gachaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gachaModalLabel">Gacha Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="gachaResultImages"></div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm modal cho lịch sử mua pack -->
<div class="modal fade" id="purchaseHistoryModal" tabindex="-1" role="dialog" aria-labelledby="purchaseHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseHistoryModalLabel">Purchase History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content for purchase history modal -->
            </div>
        </div>
    </div>
</div>

<!-- Cập nhật view để bắt sự kiện click và gửi yêu cầu AJAX -->
<div class="container">
    <h2>Your Owned Packs</h2>
    <div class="row">
        @foreach ($ownedPacks as $ownedPack)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $ownedPack->pack->PackName }}</h5>
                        <p class="card-text">Owned since: {{ $ownedPack->NgaySoHuu }}</p>
                        <!-- Button to trigger random gacha and display result in modal -->
                        <button type="button" class="btn btn-primary random-gacha" data-pack-id="{{ $ownedPack->pack->PackID }}">Random Gacha</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-primary purchase-history">Purchase History</button>
    
</div>
<script>
    $(document).ready(function() {
        $('.random-gacha').click(function() {
        var packId = $(this).data('pack-id');
        $.ajax({
            type: "POST",
            url: "{{ route('randomize.cards', ['packId' => ':packId']) }}".replace(':packId', packId),
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                if (response.success) {
                    // Xử lý kết quả và hiển thị trong modal
                    var imagesHtml = '';
                    response.cardImages.forEach(function(image) {
                        imagesHtml += '<img src="/img/item_img/' + image + '" class="img-thumbnail mr-2" style="width: 100px; height: 150px;">';
                    });
                    $('#gachaResultImages').html(imagesHtml);
                    $('#gachaModal').modal('show');
                } else {
                    // Hiển thị modal thông báo
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    $('.purchase-history').click(function() {
    // Gửi yêu cầu AJAX để lấy thông tin lịch sử mua pack
    $.ajax({
        type: "GET",
        url: "{{ route('purchase.history') }}",
        success: function(response) {
            // Hiển thị lịch sử mua pack trong modal
            $('#purchaseHistoryModal .modal-body').html(response);
            $('#purchaseHistoryModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
});
</script>

