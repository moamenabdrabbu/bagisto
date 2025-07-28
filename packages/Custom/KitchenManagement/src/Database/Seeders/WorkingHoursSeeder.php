<?php

namespace Custom\KitchenManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Custom\KitchenManagement\Models\WorkingHours;

class WorkingHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultWorkingHours = config('kitchen-management.default_working_hours');

        foreach ($defaultWorkingHours as $day => $config) {
            WorkingHours::updateOrCreate(
                ['day_of_week' => $day],
                [
                    'is_working_day' => $config['is_working_day'],
                    'start_time' => $config['start_time'],
                    'end_time' => $config['end_time'],
                ]
            );
        }
    }
} 