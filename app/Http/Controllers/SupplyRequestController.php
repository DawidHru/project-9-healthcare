<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\SupplyRequest;
use Illuminate\Http\Request;

class SupplyRequestController extends Controller
{
    public function index()
    {
        $requests = SupplyRequest::all();
        return view('supplies.index', compact('requests'));
    }
    
    public function approve(string $id)
    {
        // Find the supply request
        $request = SupplyRequest::findOrFail($id);
    
        // Find the inventory item
        $inventoryItem = InventoryItem::findOrFail($request->item_id);  // Correct the usage of $request here
    
        // Update the inventory quantity
        $inventoryItem->quantity += $request->quantity;
        $inventoryItem->save(); // Save the updated quantity
    
        // Delete the supply request after approving it
        $request->delete();
    
        return redirect()->route('supplies.index')->with('success', 'Supply request has been approved.');
    }
    

    public function destroy(string $id)
    {
        $request = SupplyRequest::findOrFail($id);
        $request->delete();
        return redirect()->route('supplies.index')->with('success', 'Supply request deleted successfully.');
    }
}
