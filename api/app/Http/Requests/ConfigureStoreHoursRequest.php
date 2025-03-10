<?php

namespace App\Http\Requests;

use App\Models\Weekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ConfigureStoreHoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [            
            'storeHours' => [                
                function ($attribute, $value, $fail) {
                    // Get all keys from the array i.e Monday, Tuesday, Wednesday etc
                    $keys = collect($value)->keys();                    
                    
                    // Get the count of weekdays from the database
                    $weekdays = Weekday::whereIn('value', $keys )->count();
                    
                    // check if same length
                    if($weekdays != $keys->count()){
                        $fail('Invalid weekdays');
                    }
                },
            ],            
            'storeHours.*' => 'required|array',            
            'storeHours.*.open' => [
                'required',
                'string',
                'regex:/^([0-1][0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/',
            ],
            'storeHours.*.close' => [
                'required',
                'string',
                'regex:/^([0-1][0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/',
            ],           
            'storeHours.*.break_time_start' => [
                'required',
                'string',
                'regex:/^([0-1][0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/',
            ],
            'storeHours.*.break_time_end' => [
                'required',
                'string',
                'regex:/^([0-1][0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/',
            ],
            'storeHours.*.every_other_week' => 'required|boolean',
            'storeHours.*.enabled' => 'required|boolean',
        ];
    }

    protected function failedValidation(Validator $validator): JsonResponse
    {
        
        $errors = ['errors' => $validator->errors()];

        throw new HttpResponseException(
            response()->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
