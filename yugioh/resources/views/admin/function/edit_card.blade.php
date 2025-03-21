@extends('admin.layout.app')

@section('content')
    <h1>Edit Card</h1>

    <form action="{{ route('cards.update', $item->ItemID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ItemName">Title:</label>
            <input type="text" name="ItemName" id="ItemName" class="form-control" value="{{ $item->ItemName }}" required>
        </div>
        <div class="form-group">
            <label for="ItemCategory">Category:</label>
            <select name="ItemCategory" id="ItemCategory" class="form-control" required>
                <!-- Add your options based on available categories -->
                <option value="SC" {{ $item->ItemCategory === 'SC' ? 'selected' : '' }}>Spell Card</option>
                <option value="TC" {{ $item->ItemCategory === 'TC' ? 'selected' : '' }}>Trap Card</option>
                <option value="MC" {{ $item->ItemCategory === 'MC' ? 'selected' : '' }}>Monster Card</option>
                <option value="FM" {{ $item->ItemCategory === 'FM' ? 'selected' : '' }}>Fusion Monster</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Description">Description:</label>
            <textarea name="Description" id="Description" class="form-control" rows="3">{{ $item->Description }}</textarea>
        </div>
        <div class="form-group">
            <label for="item_image">Image:</label>
            <input type="file" name="item_image" id="item_image" class="form-control-file">
        </div>
        @if ($item->image)
            <div class="form-group">
                <label>Current Image:</label>
                <img src="{{ asset('img/item_img/' . $item->image) }}" alt="{{ $item->ItemName }}" class="img-thumbnail" style="width: 50px; height: 50px;">
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
