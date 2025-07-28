<?php

namespace Custom\KitchenManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkingHours extends Model
{
    protected $table = 'kitchen_working_hours';

    protected $fillable = [
        'day_of_week',
        'is_working_day',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'is_working_day' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Check if kitchen is currently open.
     */
    public static function isKitchenOpen(): bool
    {
        $now = Carbon::now();
        $dayOfWeek = strtolower($now->format('l')); // monday, tuesday, etc.
        
        $workingHours = self::where('day_of_week', $dayOfWeek)->first();
        
        if (!$workingHours || !$workingHours->is_working_day) {
            return false;
        }

        $currentTime = $now->format('H:i:s');
        $startTime = $workingHours->start_time->format('H:i:s');
        $endTime = $workingHours->end_time->format('H:i:s');

        return $currentTime >= $startTime && $currentTime <= $endTime;
    }

    /**
     * Get next working day.
     */
    public static function getNextWorkingDay(): ?Carbon
    {
        $now = Carbon::now();
        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        
        // Start from tomorrow
        $checkDate = $now->copy()->addDay();
        
        // Check next 7 days
        for ($i = 0; $i < 7; $i++) {
            $dayOfWeek = strtolower($checkDate->format('l'));
            
            $workingHours = self::where('day_of_week', $dayOfWeek)->first();
            
            if ($workingHours && $workingHours->is_working_day) {
                return $checkDate;
            }
            
            $checkDate->addDay();
        }
        
        return null;
    }

    /**
     * Get working hours for a specific day.
     */
    public static function getWorkingHoursForDay(string $dayOfWeek): ?self
    {
        return self::where('day_of_week', strtolower($dayOfWeek))->first();
    }

    /**
     * Get all working hours.
     */
    public static function getAllWorkingHours(): array
    {
        $workingHours = self::all()->keyBy('day_of_week');
        
        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $result = [];
        
        foreach ($days as $day) {
            $result[$day] = $workingHours->get($day, new self([
                'day_of_week' => $day,
                'is_working_day' => false,
                'start_time' => null,
                'end_time' => null,
            ]));
        }
        
        return $result;
    }
} 