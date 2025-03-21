<style>
    .main {
        padding-top: 120px;
    }
    
    .title-card, .card-header{
        color: white;
    }
</style>

@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="main">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Tạo phiên đấu giá mới</div>
                    <div class="card-body">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="item_id" class="col-md-3 col-form-label text-md-right title-card">Chọn thẻ</label>
                            <div class="col-md-6">
                                <div class="row justify-content-around">
                                    @foreach ($ownedItems as $item)
                                    @if($item->ItemID != NULL)
                                    <div class="col-md-3 mb-5">
                                    <a href="#" data-toggle="modal" data-target="#auctionModal{{ $item->ItemID }}" onclick="setItemID('{{ $item->ItemID }}')">
                                            <img src="{{ asset('img/item_img/' . $item->item->image) }}" alt="{{ $item->item->ItemName }}" style="max-width: 100px;">
                                            <p class="text-center">Số lượng hiện có: {{ $item->Quantity }}</p>
                                        </a>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                @error('item_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@foreach ($ownedItems as $item)
@if($item->ItemID != NULL)
<div class="modal fade" id="auctionModal{{ $item->ItemID }}" tabindex="-1" role="dialog" aria-labelledby="auctionModalLabel{{ $item->ItemID }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="auctionModalLabel{{ $item->ItemID }}">Tạo phiên đấu giá mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('user.store.auction') }}">
                @csrf
                <input type="hidden" id="item_id_{{ $item->ItemID }}" name="item_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="quantity">Số lượng</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Giá đề xuất</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Tạo phiên đấu giá</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<script>
    function setItemID(itemId) {
        document.getElementById('item_id_' + itemId).value = itemId;
    }
</script>
@endsection