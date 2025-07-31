<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Carbon\Carbon;

class GenerateWeeklySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-schedule:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate schedule for the next week based on the current week';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Determine the current week's start (Monday)
        $currentWeekStart = Carbon::today()->startOfWeek();
        // Determine the next week's start
        $nextWeekStart = $currentWeekStart->copy()->addWeek();

        // Fetch schedules for the current week
        $currentSchedules = Schedule::where('week_start_date', $currentWeekStart)->get();

        // Check if there are schedules to copy
        if ($currentSchedules->isEmpty()) {
            $this->warn("No schedules found for the current week ({$currentWeekStart->toDateString()}).");
            return;
        }

        // Copy each schedule to the next week
        foreach ($currentSchedules as $schedule) {
            Schedule::create([
                'employee_id' => $schedule->employee_id,
                'pet_id' => $schedule->pet_id,
                'address_id' => $schedule->address_id,
                'service_id' => $schedule->service_id,
                'scheduled_at' => $schedule->scheduled_at->copy()->addWeek(),
                'week_start_date' => $nextWeekStart,
            ]);
        }

        $this->info("Schedule for week starting {$nextWeekStart->toDateString()} generated successfully.");
    }
}