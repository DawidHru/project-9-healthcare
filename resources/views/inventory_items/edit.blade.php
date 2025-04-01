
<x-base>
    <h1>Edit Inventory Item</h1>
    <form action="{{ route('inventory_items.update', $inventoryItem->id) }}" method="POST" style="margin: 20px;">
        @csrf
        @method('POST')
        <a href="{{ route('inventory_items.index') }}" class="btn btn-secondary" style="width:100px; margin-left:40px; margin-bottom:20px;">Back</a>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $inventoryItem->name }}" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" value="{{ $inventoryItem->category }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $inventoryItem->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $inventoryItem->location }}" required>
        </div>
        <div class="form-group">
            <label for="threshold">Threshold</label>
            <input type="number" name="threshold" class="form-control" value="{{ $inventoryItem->threshold }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</x-base>
