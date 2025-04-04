<?php

namespace App\Http\Controllers;

use App\Models\EquipmentIssue;
use App\Models\MedicalEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function edit(EquipmentIssue $issue)
    {
        $issue->load(['equipment', 'reporter.user']);
        return view('medical-equipment.issues.edit', compact('issue'));
    }

    public function update(Request $request, EquipmentIssue $issue)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical'
        ]);

        $issue->update([
            'description' => $validated['description'],
            'severity' => $validated['severity']
        ]);

        return redirect()->route('equipment-issues.show', $issue)
            ->with('success', 'Issue updated successfully.');
    }

    public function updateStatus(Request $request, EquipmentIssue $issue)
    {
        // Validatie van de invoer
        $validated = $request->validate([
            'status' => 'required|in:reported,in_progress,resolved,closed',
            'resolution_notes' => 'required_if:status,resolved,closed|string|nullable',
            'resolved_by' => 'required'
        ]);
        
        // Basisupdates
        $updates = [
            'status' => $validated['status'],
        ];
        
        
        // Als de status 'resolved' of 'closed' is, voeg extra velden toe
        if (in_array($validated['status'], ['resolved', 'closed'])) {
            $updates['resolved_by'] = $validated['resolved_by']; // Stel de resolver in op de huidige gebruiker als deze niet is opgegeven
            $updates['resolved_at'] = now(); // Stel de huidige tijd in als resolved_at
            $updates['resolution_notes'] = $validated['resolution_notes']; // Voeg de resolution notes toe
            
            // Optioneel: Zet de status van de apparatuur terug naar 'available'
            $issue->equipment()->update(['status' => 'available']);
        }
        
        // Update het issue in de database
        $issue->update($updates);
        
        // Redirect terug naar de show-pagina met een succesbericht
        return redirect()->route('equipment-issues.show', $issue)
            ->with('success', 'Issue status updated successfully.');
    }
}