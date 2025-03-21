@extends('admin.layout.app')

@section('content')

    <div class="container">
    <a href="{{ route('packs.create') }}" class="btn btn-success">Create Packs</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Quản lý gói thẻ</div>
                    <div class="card-body">
                        <div class="table-responsive"> <!-- Thêm lớp table-responsive -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID gói thẻ</th>
                                        <th>Tên gói thẻ</th>
                                        <th>Ảnh</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packs as $pack)
                                        <tr>
                                            <td>{{ $pack->PackID }}</td>
                                            <td>{{ $pack->PackName }}</td>
                                            <td>
                                                <img src="{{ asset('img/pack_image/' . $pack->Image_pack) }}" alt="Pack Image" style="max-width: 100px;">
                                            </td>
                                            <td>
                                                <a href="{{ route('packs.show', $pack->PackID) }}" class="btn btn-primary">View</a>
                                                <a href="{{ route('packs.edit', $pack->PackID) }}" class="btn btn-warning">Edit</a> <!-- Thêm nút Edit -->
                                                <a href="{{ route('packs.destroy', $pack->PackID) }}" class="btn btn-danger">Destroy</a> <!-- Thêm nút Edit -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
