<x-base>
    <h1>View Inventory Item</h1>
    <a href="{{ route('inventory_items.index') }}" class="btn btn-secondary" style="width:100px; margin-left:40px; margin-bottom:20px;">Back</a>
    <table class="table table-bordered" style="width: 100%; margin: 0 auto;">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Threshold</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $inventoryItem->id }}</td>
                <td>{{ $inventoryItem->name }}</td>
                <td>{{ $inventoryItem->category }}</td>
                <td>{{ $inventoryItem->quantity }}</td>
                <td>{{ $inventoryItem->location }}</td>
                <td>{{ $inventoryItem->threshold }}</td>
            </tr>
        </tbody>
    </table>
</x-base>
