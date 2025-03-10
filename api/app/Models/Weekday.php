<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    /** @use HasFactory<\Database\Factories\WeekdayFactory> */
    use HasFactory;

    protected $fillable = ['name', 'value', 'enabled'];

    public function storeHours(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(WeekdayStoreHour::class);
    }
}
