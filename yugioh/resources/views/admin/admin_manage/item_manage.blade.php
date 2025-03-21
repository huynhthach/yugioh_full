<style>
        .sort {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto; /* Để canh giữa .sort */
        }

        .sort .form-group {
            margin-bottom: 0; /* Loại bỏ margin dư thừa */
        }

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
    <h1>Quản lý thẻ</h1>



    <!-- Dropdown filter cho loại thẻ -->
   <!-- Dropdown filter cho loại thẻ -->
<div class="sort">
<a href="{{ route('cards.create') }}" class="btn btn-success">Thêm mới thẻ</a>

    <form action="{{ route('cards.index') }}" method="GET" class="mt-3">
    <label for="category" style="margin: 5px;">Lọc theo loại thẻ:</label>
        <div class="form-group" style="display: inline-block; vertical-align: top;">

            <select name="category" id="category" class="form-control">
                <option value="">Tất cả</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ $categoryFilter == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="display: inline-block; vertical-align: top;">Lọc</button>
    </form>
</div>


    <table class="table mt-3">
        <!-- Table header -->
        <thead>
            <tr>
                <th>ID Thẻ</th>
                <th>Tên thẻ</th>
                <th>Loại thẻ</th>
                <th>Thông tin thẻ</th>
                <th>Ảnh</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->ItemID }}</td>
                    <td>{{ $item->ItemName }}</td>
                    <td>{{ $item->ItemCategory }}</td>
                    <td>{{ $item->Description }}</td>
                    <td><img src="{{ asset('img/item_img/' . $item->image) }}" alt="{{ $item->Title }}" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                    <td>
                        <!-- Add your actions, e.g., edit and delete links/buttons -->
                        <a href="{{ route('cards.edit', $item->ItemID) }}" class="btn btn-primary">sửa</a>
                        <form action="{{ route('cards.destroy', $item->ItemID) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <!-- No items found message -->
                <tr>
                    <td colspan="6">No cards found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if($totalPages > 1)
        <div class="pagination">
            @for ($i = 1; $i <= $totalPages; $i++)
                <a href="{{ route('cards.index', ['page' => $i]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
            @endfor
        </div>
    @endif
@endsection
