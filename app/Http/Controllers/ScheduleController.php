<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Department;
use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        $departments = Department::all();
        return view('schedules.index', compact('schedules', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('schedules.create', compact('departments'));
    }

    public function store(ScheduleRequest $request)
    {
        $schedule = new Schedule();
        $this->save($schedule, $request);
        return redirect()->route('schedules.index');
    }

    public function show(string $id)    
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }

    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $departments = Department::all();
        return view('schedules.edit', compact('schedule', 'departments'));
    }

    public function update(ScheduleRequest $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $this->save($schedule, $request);
        return redirect()->route('schedules.index');
    }

    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }

    private function save($schedule, ScheduleRequest $request)
    {
        $schedule->date           = $request->date;
        $schedule->start_time     = $request->start_time;
        $schedule->end_time       = $request->end_time;
        $schedule->department_id  = $request->department_id;
        $schedule->doctor_id      = $request->doctor_id;
        $schedule->save();
    }
}
