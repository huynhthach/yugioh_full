<style>
    .main_content {
        padding-top: 120px;
    }

    .card-img-top {
        max-width: 100%;
        height: 350px;
    }

    /* Đảm bảo rằng mỗi pack có kích thước xác định và có khoảng cách giữa chúng */
    .card {
        width: 100%;
        /* Điều chỉnh kích thước của pack theo ý muốn */
        margin-bottom: 20px;
        /* Khoảng cách giữa các pack */
    }


    /* Đảm bảo rằng các pack hiển thị 3 pack trên mỗi hàng khi màn hình đủ rộng */
    @media (min-width: 768px) {
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
    }
</style>

@extends('layout.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Mua pack thành công</h5>
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn đã mua pack thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close-id"  data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="main_content">
        <div class="text-center">
            <h2>Danh sách các pack</h2>
        </div>
        <div class="row justify-content-center">
            @foreach($packs as $pack)
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="{{ asset('img/pack_image/' . $pack->Image_pack) }}" class="card-img-top pack-image" alt="{{ $pack->PackName }}">
                    <div class="card-body justify-content-center">
                        <h3 class="card-title">{{ $pack->PackName }}</h3>
                        <p class="card-text">Giá: {{ $pack->Price }} VND</p>
                        <form action="{{ route('user.buyPack', $pack->PackID) }}" method="POST">
                            @csrf
                            <input type="hidden" id="userLoggedIn" value="{{ Auth::check() ? 'true' : 'false' }}">
                            <div class="input-group justify-content-center">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-primary subtract" onclick="subtractQuantity(this)">-</button>
                                </div>
                                <input id="quantityInput_{{ $pack->PackID }}" type="number" name="quantity" value="1" min="1" max="50" class="form-control text-center col-md-4">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary add" onclick="addQuantity(this)">+</button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 d-block mx-auto">Mua pack</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    
 // Hàm thêm giá trị vào trường input số lượng
 function addQuantity(button) {
        const input = button.parentElement.previousElementSibling;
        let value = parseInt(input.value);
        if (value < 50) {
            value++;
            input.value = value;
        }
    }

    // Hàm giảm giá trị của trường input số lượng
    function subtractQuantity(button) {
        const input = button.parentElement.nextElementSibling;
        let value = parseInt(input.value);
        if (value > 1) {
            value--;
            input.value = value;
        }
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            const url = form.action;
            if(checkLoggedIn()) {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    // Hiển thị modal khi mua pack thành công
                    $('#successModal').modal('show');
                } else {
                    showAlert(data.message, 'success');
                }
            } else {
                window.location.href = "{{ route('login') }}";
            }
        });
    });


    // Hàm hiển thị thông báo
function showAlert(message, type) {
    // Thực hiện hiển thị thông báo ở đây, ví dụ:
    alert(message); // Hiển thị thông báo thông qua hộp thoại cảnh báo
}

    // Hàm kiểm tra xem người dùng đã đăng nhập chưa
function checkLoggedIn() {
    // Thực hiện kiểm tra người dùng đã đăng nhập ở đây, ví dụ:
    return document.querySelector('#userLoggedIn').value === 'true'; // Giả sử bạn có một input hidden có id là userLoggedIn
}

    // Xử lý khi người dùng click vào nút "Close" trong modal
    document.getElementById('close-id').addEventListener('click', function() {
        // Làm mới trang
        location.reload();
    });
</script>

@endsection