<x-base>
    <div class="container">
        <form method="POST" action="{{ route('inventory_items.store_request') }}">
            @csrf
            <div class="mb-3">
                <label for="item_id" class="form-label">Select Item</label>
                <select class="form-control" id="item_id" name="item_id" required>
                    <option value="" disabled selected>Choose an item</option>
                    @foreach ($inventoryItems as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->quantity}} left)</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary">Request Item</button>
        </form>
    </div>
</x-base>
