<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekdayStoreHour extends Model
{
    /** @use HasFactory<\Database\Factories\WeekdayStoreHourFactory> */
    use HasFactory;

    protected $fillable = [
        'weekday_id',
        'open',
        'close',
        'break_time_start',
        'break_time_end',
        'every_other_week',
    ];
}
