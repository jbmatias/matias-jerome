<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetStoreHoursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [          
            'id' => $this->id,
            'name' => $this->name,
            'day_num' => Carbon::parse($this->value)->dayOfWeek,
            'value' => $this->value,
            'enabled' => $this->enabled,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'store_hours' => $this->storeHours
        ];
    }
}
