<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTimeLogRequest;
use App\Http\Requests\UpdateTimeLogRequest;
use App\Models\TimeLog;
use DB;

class TimeLogController extends Controller
{
    public function index()
    {
        $logs = TimeLog::orderBy('work_date', 'desc')->get()
            ->groupBy('work_date');
        return view('time_logs.index', compact('logs'));
    }

    public function store(StoreTimeLogRequest $request)
{
    $workDate = $request->work_date;

    $totalMinutes = TimeLog::where('work_date', $workDate)->sum(DB::raw('hours * 60 + minutes'));

    foreach ($request->description as $index => $desc) {
        $taskMinutes = ($request->hours[$index] * 60) + $request->minutes[$index];
        $totalMinutes += $taskMinutes;

        if ($taskMinutes > 600) {
            return back()->withErrors(['Task cannot exceed 10 hours']);
        }

        if ($totalMinutes > 600) {
            return back()->withErrors(['Total daily time cannot exceed 10 hours']);
        }

        TimeLog::create([
            'work_date' => $workDate,
            'description' => $desc,
            'hours' => $request->hours[$index],
            'minutes' => $request->minutes[$index],
        ]);
    }

    return redirect()->route('time_logs.index')->with('success', 'Tasks logged successfully.');
}
    public function edit(TimeLog $timeLog)
    {
        return view('time_logs.edit', compact('timeLog'));
    }

  public function update(UpdateTimeLogRequest $request, TimeLog $timeLog)
{
    $existingMinutes = TimeLog::where('work_date', $timeLog->work_date)
        ->where('id', '!=', $timeLog->id)
        ->sum(DB::raw('hours * 60 + minutes'));

    $updatedMinutes = $request->hours * 60 + $request->minutes;

    if (($existingMinutes + $updatedMinutes) > 600) {
        return back()->withErrors(['Total daily time cannot exceed 10 hours']);
    }

    $timeLog->update([
        'description' => $request->description,
        'hours' => $request->hours,
        'minutes' => $request->minutes,
    ]);

    return redirect()->route('time_logs.index')->with('success', 'Task updated successfully.');
}
}
