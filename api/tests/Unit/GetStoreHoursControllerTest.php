<?php

use App\Models\Weekday;
use App\Models\WeekdayStoreHour;
use Illuminate\Http\Response;

beforeEach(function () {    
    $this->withoutExceptionHandling();
    $this->artisan('db:seed');
});

test('Get Store Hours', function () {                
    $response = $this->get(route('index.store-hours'));

    $response->assertStatus(Response::HTTP_OK);

    $data = Weekday::with('storeHours')->get();
    $response->assertJson(['data' => $data->toArray()]);    

    $this->assertDatabaseCount('weekday_store_hours', 7);
});
