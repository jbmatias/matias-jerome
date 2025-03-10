<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Weekday;
use App\Models\WeekdayStoreHour;
use Database\Factories\WeekdayStoreHourFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get Days in a Week using Carbon
        $days = collect(range(0, 6))->map(fn($day) => [
            'name' => now()->startOfWeek()->addDays($day)->format('l'),            
            'value' => strtolower(now()->startOfWeek()->addDays($day)->format('l')),
            'enabled' => ! in_array(strtolower(now()->startOfWeek()->addDays($day)->format('l')), ['monday', 'wednesday', 'friday', 'saturday']) ? false : true,
        ]);
                
        $data = Weekday::factory()->createMany($days);

        foreach ($data as $weekday) {
            WeekdayStoreHour::factory()->create([
                'weekday_id' => $weekday->id,
                'open' => '08:00:00',
                'close' => '16:00:00',                
                'break_time_start' => '12:00:00',
                'break_time_end' => '12:45:00',
                'every_other_week' => $weekday->value != 'saturday' ? false : true,
            ]);
        }        
    }
}
