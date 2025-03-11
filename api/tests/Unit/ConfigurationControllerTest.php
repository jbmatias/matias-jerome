<?php

use App\Models\WeekdayStoreHour;
use Illuminate\Http\Response;

beforeEach(function () {    
    $this->withoutExceptionHandling();
    $this->artisan('db:seed');
});

test('Handle Update Configuration Request with correct payload', function () {                
    $response = $this->put(route('update.store-hours'), [
        'storeHours' => [
            'monday' => generateWeekdayStoreHourData(),
            'tuesday' => generateWeekdayStoreHourData(),
            'wednesday' => generateWeekdayStoreHourData(),
            'thursday' => generateWeekdayStoreHourData(),
            'friday' => generateWeekdayStoreHourData(),
            'saturday' => generateWeekdayStoreHourData(),
            'sunday' => generateWeekdayStoreHourData(),
        ],            
    ]);

    $response->assertStatus(Response::HTTP_OK);
    $response->assertJson([
        'message' => 'Store hours updated successfully',
    ]);    

    $this->assertDatabaseCount('weekday_store_hours', 7);
});


test('Handle Update Configuration Request with incorrect payload', function () {          
    $response = $this->put(route('update.store-hours'), [
        'storeHours' => [
            'monday1' => generateWeekdayStoreHourData(),
            'tuesday' => generateWeekdayStoreHourData(),
            'wednesday' => generateWeekdayStoreHourData(),
            'thursday' => generateWeekdayStoreHourData(),
            'friday' => generateWeekdayStoreHourData(),
            'saturday' => generateWeekdayStoreHourData(),
            'sunday' => generateWeekdayStoreHourData(),
        ],
    ]);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJson([
        'errors' => [
            'storeHours' => ["Invalid weekdays"]
        ],
    ]);    

    $this->assertDatabaseCount('weekday_store_hours', 7);
});
