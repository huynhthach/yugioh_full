@foreach ($receiptDetails as $receiptDetail)
@foreach($receiptDetail->recieptdetail as $detail)
<div class="border mb-3 p-3">
    <p>Tên Pack: {{ $detail->pack->PackName }}</p>
    <p>Số lượng: {{ $detail->Quantity }}</p>
    <p>Ngày mua: {{ $receiptDetail->RecieptDate }}</p>
    </div>
    <hr> <!-- Đường kẻ ngang -->
@endforeach 
@endforeach
