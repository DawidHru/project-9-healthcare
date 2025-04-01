<x-base>
    <h1>Supply Requests</h1>
    <table class="table table-bordered" style="width: 100%; margin: 0 auto;">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Status</th>
                <th style="width: 300px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->inventoryItem->name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        <div style="display: flex; justify-content: space-between; gap: 15px;">
                            <form action="{{ route('supplies.approve', $request->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-success btn-sm" style="width: 120px;">Approve</button>
                            </form> 

                            <form action="{{ route('supplies.destroy', $request->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="width: 120px;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-base>
