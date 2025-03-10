<?php

namespace App\Actions;

use App\Models\Weekday;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class ConfigureStoreHoursAction
{
    use AsAction;

    public function handle(array $attributes)
    {        

        foreach ($attributes as $key => $value) {
            
            $weekday = Weekday::where('value', $key)->with('storeHours')->first();            
            $weekday->enabled = $value['enabled'];
            $weekday->save();
            Log::info($value);
            $weekday->storeHours->update($value);
        }
        
        return response()->json(['message' => 'Store hours updated successfully']);
    }
}
