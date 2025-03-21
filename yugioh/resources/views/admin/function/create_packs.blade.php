@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h2>Tạo gói thẻ</h2>
        <form action="{{ route('packs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="pack_name">Tên gói thẻ:</label>
                <input type="text" class="form-control" id="pack_name" name="pack_name" style="width: 500px;">
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" style="width: 200px;">
            </div>
            <div class="form-group">
                <label for="selected_items">chọn thẻ:</label>
                <div class="row">
                    @foreach($items as $key => $item)
                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" class="item-checkbox" name="selected_items[]" value="{{ $item->ItemID }}">
                                {{ $item->ItemName }}
                            </label>
                            <br>
                            <img src="{{ asset('img/item_img/' . $item->image) }}" alt="{{ $item->ItemName }}" style="max-width: 100px;">
                            <input type="number" name="rates[]" class="rate-input" placeholder="Rate (0-100%)" step="1" min="0" max="100" style="width: 120px;" disabled>
                        </div>
                    @endforeach
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="pack_image">Image:</label>
                <input type="file" name="pack_image" id="pack_image" class="form-control-file" accept="image/jpeg, image/png, image/gif">
            </div>
            <button type="submit" class="btn btn-primary">Create Pack</button>
        </form>
    </div>

    <script>
        // Lắng nghe sự kiện khi checkbox được chọn hoặc bỏ chọn
        document.querySelectorAll('.item-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Tìm ô nhập rate tương ứng với checkbox
                var rateInput = this.parentElement.parentElement.querySelector('.rate-input');

                // Bật hoặc tắt ô nhập rate dựa trên trạng thái của checkbox
                if (this.checked) {
                    rateInput.removeAttribute('disabled');
                } else {
                    rateInput.setAttribute('disabled', 'disabled');
                }
            });
        });
    </script>
@endsection
