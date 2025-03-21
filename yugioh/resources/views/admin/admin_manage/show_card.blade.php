@extends('admin.layout.app')
@section('content')
    <div class="container">
        <h2>Chi tiết gói thẻ - {{ $pack->PackName }}</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Danh sách thẻ</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Image</th> <!-- Thêm cột mới cho ảnh -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cards as $card)
                                    <tr>
                                        <td>{{ $card->card->ItemID }}</td>
                                        <td>{{ $card->card->ItemName }}</td>
                                        <td>{{ $card->Quantity }}</td>
                                        <td><img src="{{ asset('img/item_img/' . $card->card->image) }}" alt="{{ $card->card->ItemName }}" style="max-width: 100px;"></td> <!-- Hiển thị ảnh -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
