<x-base>
    <h1>Welcome to the Inventory!</h1>
    <a href="{{ route('inventory_items.create') }}" class="btn btn-primary" style="width:100px; margin-left:40px; margin-bottom:20px;">Create</a>
    
    <div class="mb-2">
        <div class="row">
            <div class="filter-container">
                <select id="catFilter" class="form-control">
                    <option value="">Filter by category</option>
                    @foreach ($inventoryItems->pluck('category')->unique() as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>            
        </div>
    
    <table id="itemTable" class="table table-bordered" style="width: 100%; margin: 0 auto;">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Threshold</th>
                <th style="width: 500px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventoryItems as $item)
                <tr class="item-row">
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="item-category">{{ $item->category }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->threshold}}</td>
                    <td>
                        <div style="display: flex; justify-content:space-between; gap:15px;">
                            <a href="inventory_items/{{$item->id}}" class="btn btn-info btn-sm" style="width: 150px">View</a>
                            <a href="inventory_items/edit/{{$item->id}}" class="btn btn-success btn-sm" style="width: 150px">Edit</a>
                            <form action="{{ route('inventory_items.destroy', $item->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="width: 150px;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-base>

<script>

        // Search function
        // // searchvalue is de naam in de searchbar, en de function zoekt deze op in tussen alle namen in de
        // searchInput.addEventListener("input", function() {
        //     const searchValue = this.value.toLowerCase();
        //     kidRows.forEach(row => {
        //         const name = row.querySelector(".kid-name").textContent.toLowerCase();
        //         row.style.display = name.includes(searchValue) ? "" : "none";
        //     });
        // });

        // Filter function, by category
        document.addEventListener("DOMContentLoaded", function() {
        const catFilter = document.getElementById("catFilter");    
        const itemTable = document.getElementById("itemTable");
        const itemRows = itemTable.querySelectorAll(".item-row");

        catFilter.addEventListener("change", function() {
            const selectedCategory = this.value;
            itemRows.forEach(row => {
                const category = row.querySelector(".item-category").textContent;
                row.style.display = selectedCategory === "" || category === selectedCategory ? "" : "none";
            });
        });
    });


    function confirmDelete() {
        return confirm('Are you sure you want to delete this product? This action cannot be undone.');
    }

</script>
