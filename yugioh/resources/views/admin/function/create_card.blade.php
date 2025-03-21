@extends('admin.layout.app')

@section('content')
    <h1>Create Card</h1>

    <form action="{{ route('cards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="ItemName">ItemName:</label>
            <input type="text" name="ItemName" id="ItemName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ItemCategory">Category:</label>
            <select name="ItemCategory" id="ItemCategory" class="form-control" required>
                <!-- Add your options based on available categories -->
                <option value="SC">Spell Card</option>
                <option value="TC">Trap Card</option>
                <option value="MC">Monster Card</option>
                <option value="FM">Fusion Monster</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Description">Description:</label>
            <textarea name="Description" id="Description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="item_image">Image:</label>
            <input type="file" name="item_image" id="item_image" class="form-control-file" accept="image/jpeg, image/png, image/gif">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection
