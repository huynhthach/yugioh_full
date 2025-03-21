@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h2>Edit Pack</h2>
        <form action="{{ route('packs.update', $pack->PackID) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="pack_name">Pack Name:</label>
                <input type="text" class="form-control" id="pack_name" name="pack_name" value="{{ $pack->PackName }}" style="width: 500px;">
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $pack->Price }}" style="width: 200px;">
            </div>
            <div class="form-group">
                <label>Select Items:</label>
                <div class="row">
                    @foreach($items as $item)
                        <div class="col-md-3">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->ItemID }}" {{ in_array($item->ItemID, $pack->packCards->pluck('CardID')->toArray()) ? 'checked' : '' }} class="item-checkbox">
                                {{ $item->ItemName }}
                            </label>
                            <br>
                            <img src="{{ asset('img/item_img/' . $item->image) }}" alt="{{ $item->ItemName }}" style="max-width: 100px;">
                            <br>
                            <input type="number" name="rates[]" placeholder="Rate (0-100%)" step="1" min="0" max="100" value="{{ $pack->packCards->where('CardID', $item->ItemID)->first()->Rate ?? '' }}" style="width: 40%;margin-top: 5px;" class="rate-input" {{ in_array($item->ItemID, $pack->packCards->pluck('CardID')->toArray()) ? '' : 'style=display:none' }}>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="pack_image">Image:</label>
                <input type="file" name="pack_image" id="pack_image" class="form-control-file" accept="image/jpeg, image/png, image/gif">
            </div>
            <button type="submit" class="btn btn-primary">Update Pack</button>
        </form>
    </div>

    <script>
        // JavaScript to show/hide rate inputs based on checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const rateInput = this.parentNode.nextElementSibling.nextElementSibling.querySelector('.rate-input');
                    if (this.checked) {
                        rateInput.style.display = 'block';
                    } else {
                        rateInput.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
