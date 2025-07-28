<?php

namespace Custom\KitchenManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Custom\KitchenManagement\Models\WorkingHours;

class WorkingHoursController extends Controller
{
    /**
     * Display the working hours configuration page.
     */
    public function index()
    {
        $workingHours = WorkingHours::getAllWorkingHours();
        $isKitchenOpen = WorkingHours::isKitchenOpen();
        
        return view('kitchen-management::working-hours.index', compact('workingHours', 'isKitchenOpen'));
    }

    /**
     * Update working hours configuration.
     */
    public function update(Request $request)
    {
        $request->validate([
            'working_hours' => 'required|array',
            'working_hours.*.is_working_day' => 'boolean',
            'working_hours.*.start_time' => 'nullable|date_format:H:i',
            'working_hours.*.end_time' => 'nullable|date_format:H:i',
        ]);

        $workingHours = $request->input('working_hours');

        foreach ($workingHours as $day => $config) {
            WorkingHours::updateOrCreate(
                ['day_of_week' => $day],
                [
                    'is_working_day' => $config['is_working_day'] ?? false,
                    'start_time' => $config['start_time'] ?? null,
                    'end_time' => $config['end_time'] ?? null,
                ]
            );
        }

        return redirect()->route('kitchen-management.working-hours.index')
            ->with('success', 'Working hours updated successfully!');
    }

    /**
     * Get working hours for API.
     */
    public function getWorkingHours()
    {
        $workingHours = WorkingHours::getAllWorkingHours();
        $isKitchenOpen = WorkingHours::isKitchenOpen();
        
        return response()->json([
            'working_hours' => $workingHours,
            'is_kitchen_open' => $isKitchenOpen,
        ]);
    }

    /**
     * Get kitchen status for API.
     */
    public function getKitchenStatus()
    {
        $isKitchenOpen = WorkingHours::isKitchenOpen();
        $nextWorkingDay = WorkingHours::getNextWorkingDay();
        
        return response()->json([
            'is_kitchen_open' => $isKitchenOpen,
            'next_working_day' => $nextWorkingDay ? $nextWorkingDay->format('Y-m-d H:i:s') : null,
        ]);
    }
} 