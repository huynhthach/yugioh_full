<style>
    .text {
    padding-top: 80px;
    }
</style>

@extends('layout.app')

@section('content')
<div class="text">
    <div class="container mt-4">
        <h2>Catalogs</h2>

        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->CategoryName }}</h5>
                            <a href="{{ route('cardset.show', $category->CategoryID) }}" class="btn btn-primary">View Catalog</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
