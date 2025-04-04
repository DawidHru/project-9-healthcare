<?php

namespace App\Http\Controllers;

use App\Models\EquipmentIssue;
use App\Models\MedicalEquipment;
use Illuminate\Http\Request;

class EquipmentIssueController extends Controller
{
    public function create(MedicalEquipment $equipment)
    {
        return view('medical-equipment.issues.create', compact('equipment'));
    }

    public function store(Request $request, MedicalEquipment $equipment)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'reported_by' => 'required',
            'severity' => 'required|in:low,medium,high,critical',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $issue = $equipment->issues()->create([
            'reported_by' => $validated['reported_by'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
            'status' => 'reported'
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $issue->addMedia($image)->toMediaCollection('issue_images');
            }
        }

        // Set equipment status to maintenance
        $equipment->update(['status' => 'maintenance']);

        return redirect()->route('medical-equipment.show', $equipment)
            ->with('success', 'Issue reported successfully.');
    }

    public function show(EquipmentIssue $issue)
    {
        // Eager load relationships to prevent N+1 queries
        $issue->load([
            'equipment',
            'reporter.user',
            'resolver.user'
        ]);

        return view('medical-equipment.issues.show', [
            'issue' => $issue,
        ]);
    }

    public function updateStatus(Request $request, EquipmentIssue $issue)
    {
        $validated = $request->validate([
            'status' => 'required|in:in_progress,resolved,closed',
            'resolution_notes' => 'required_if:status,resolved,closed|string|nullable'
        ]);

        $updates = [
            'status' => $validated['status'],
            'resolved_by' => $validated['resolved_by'],
            'resolution_notes' => $validated['resolution_notes'] ?? null
        ];

        // If resolving or closing the issue, set resolved_by and resolved_at
        if (in_array($validated['status'], ['resolved', 'closed'])) {
            $updates['resolved_by'] = $validated['resolved_by'] ?? null;
            $updates['resolved_at'] = now();
            
            // Optionally set equipment back to available if issue is resolved
            if ($validated['status'] === 'resolved') {
                $issue->equipment()->update(['status' => 'available']);
            }
        }

        $issue->update($updates);

        return back()->with('success', 'Issue status updated successfully.');
    }
}