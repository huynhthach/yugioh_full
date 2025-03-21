<style>
    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .pagination a {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 5px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
    }

    .pagination a.active {
        background-color: #007bff;
        color: #fff;
    }
</style>

@extends('admin.layout.app')

@section('content')

<div class="container-fluid"> <!-- Thay đổi lớp container thành container-fluid để làm cho nó responsive -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý hoá đơn</div>
                <div class="card-body">
                    <form action="{{ route('reciept.index') }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="start_date">Ngày bắt đầu:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->input('start_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="end_date">Ngày kết thúc:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->input('end_date') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary">Thống kê</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive"> <!-- Thêm lớp table-responsive -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID hoá đơn</th>
                                    <th>Người mua</th>
                                    <th>Người bán</th>
                                    <th>Loại giao dịch</th>
                                    <th>Tổng số tiền</th>
                                    <th>Ngày bán</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reciept as $receipt)
                                <tr>
                                    <td>{{ $receipt->RecieptID }}</td>
                                    @if( $receipt->buyer !=NULL)
                                    <td>{{ $receipt->buyer->Username }}</td>
                                    @else
                                    <td>Không có người mua</td>
                                    @endif
                                    @if( $receipt->seller !=NULL)
                                    <td>{{ $receipt->seller->Username }}</td>
                                    @else
                                    <td>Không có người bán</td>
                                    @endif
                                    <td>{{ $receipt->category_reciept->CategoryName }}</td>
                                    <td>{{ $receipt->TotalAmount }}</td>
                                    <td>{{ $receipt->RecieptDate }}</td>
                                    <td>
                                        <a href="{{ route('reciept.detail', $receipt->RecieptID) }}" class="btn btn-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    @if($totalPages > 1)
                    <div class="pagination">
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <a href="{{ route('reciept.index', ['page' => $i]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                        @endfor
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
