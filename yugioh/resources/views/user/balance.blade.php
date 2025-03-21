<style>
    .main {
        padding-top: 100px;
    }

    .amout{
        color: white;
    }
</style>


@extends('layout.app')

@section('content')
<div class="main">
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Add Balance</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('balance.add') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="amount" class="amout">Amount:VND</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="0" step="0.01" required>
                        </div>
                        <!-- Trường ẩn redirect -->
                        <input type="hidden" name="redirect" value="true">
                        <button type="submit" class="btn btn-primary btn-block">Add Balance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
