<?php

namespace App\Actions;

use App\Http\Resources\GetStoreHoursResource;
use App\Models\Weekday;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStoreHoursAction
{
    use AsAction;

    public function handle(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $data = Weekday::with('storeHours')->get();
        return GetStoreHoursResource::collection($data);
    }
}
