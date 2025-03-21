<style>
    .main {
        padding-top: 20px;
    }

    .title-card {
        color: white;
    }
</style>

<div class="container mt-4">
    <div class="main">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="item_id" class="col-md-3 col-form-label text-md-right title-card">Thẻ của bạn</label>
                            <div class="col-md-6">
                                <div class="row justify-content-around">
                                    @foreach ($ownedCards as $item)
                                    @if($item->ItemID != NULL)
                                    <div class="col-md-3 mb-5">
                                        <a href="#" class="card-link" data-card-id="$item->ItemID" data-toggle="modal" data-target="#cardModal{{ $item->ItemID }}">

                                            <img src="{{ asset('img/item_img/' . $item->item->image) }}" alt="{{ $item->item->ItemName }}" style="max-width: 100px;">
                                            <p class="text-center">Số lượng hiện có: {{ $item->Quantity }}</p>
                                    </div>
                                    <!-- Modal for each item -->
                                    <div class="modal fade custom-modal smaller-modal" id="cardModal{{ $item->ItemID }}" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel{{ $item->ItemID }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        {{ $item->item->ItemName }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <!-- Display image in modal -->
                                                            @if ( $item->item->image)
                                                            <img src="{{ asset('img/item_img/' . $item->item->image) }}" class="img-fluid smaller-image" alt="{{ $item->item->ItemName }}">
                                                            @else
                                                            <p>No image available</p>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <!-- Display name and description in modal -->
                                                            <div class="modal-description">
                                                                <p><strong>Name:</strong> {{ $item->item->ItemName  }}</p>
                                                                <p><strong>Description:</strong></p>
                                                                {{ $item->item->Description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
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