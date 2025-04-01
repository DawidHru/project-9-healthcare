<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\SupplyRequest;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::all();
        return view('inventory_items.index', compact('inventoryItems'));
    }

    public function create()
    {
        return view('inventory_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'category'  => 'required|string|max:300',
            'quantity'  => 'required|integer|min:0',
            'location'  => 'required|string|max:300',
            'threshold' => 'nullable|integer|min:0',
        ]);
        
        $inventoryItem = new InventoryItem();
        $this->save($inventoryItem, $request);
        return redirect()->route('inventory_items.index');
    }

    public function request()
    {
        $inventoryItems = InventoryItem::all();
        return view('inventory_items.request', compact('inventoryItems'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'item_id'   => 'required|exists:inventory_items,id',
            'quantity'  => 'required|integer|min:1',
        ]);
    
        SupplyRequest::create([
            'item_id'  => $request->item_id,
            'quantity' => $request->quantity,
            'status'   => 'pending', // Default status
        ]);    
        return redirect()->route('supplies.index')->with('success', 'Request submitted successfully!');
    }
    
    public function show(string $id)
    {
        $inventoryItem = InventoryItem::findOrFail($id);
        return view('inventory_items.show', compact('inventoryItem'));
    }

    public function edit(string $id)
    {
        $inventoryItem = InventoryItem::findOrFail($id);
        return view('inventory_items.edit', compact('inventoryItem'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'threshold' => 'required|integer|min:0',
        ]);
    
        $inventoryItem = InventoryItem::findOrFail($id);
        $inventoryItem->update($request->only(['name', 'category', 'quantity', 'location', 'threshold']));
        
        return redirect()->route('inventory_items.index');
    }
    
    public function destroy(string $id)
    {
        $inventoryItem = InventoryItem::findOrFail($id);
        $inventoryItem->delete();
        return redirect()->route('inventory_items.index')->with('success', 'Inventory item deleted successfully.');
    }

    private function save($inventoryItem, Request $request)
    {
        $inventoryItem->name = $request->name;
        $inventoryItem->category = $request->category;
        $inventoryItem->quantity = $request->quantity;
        $inventoryItem->location = $request->location;
        $inventoryItem->threshold = $request->threshold;
        $inventoryItem->save();
    }
}
