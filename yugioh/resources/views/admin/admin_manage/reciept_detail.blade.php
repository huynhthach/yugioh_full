@extends('admin.layout.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Chi tiết hoá đơn</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Số hoá đơn:</th>
                                <td>{{ $reciept->RecieptID }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tên thẻ:</th>
                                @if ($reciept->ItemID != NULL)
                                <td>{{ $reciept->item->ItemName }}</td>
                                @else
                                <td>Không có tên thẻ</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">Tên gói thẻ:</th>
                                @if ($reciept->PackID != NULL)
                                <td>{{ $reciept->pack->PackName }}</td>
                                @else
                                <td>Không có gói thẻ</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">Số lượng:</th>
                                <td>{{ $reciept->Quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
