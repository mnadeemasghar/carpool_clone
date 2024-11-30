<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreRideRequest extends FormRequest
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
            'pick_location_id' => 'required|exists:addresses,id',
            'drop_location_id' => 'required|exists:addresses,id',
            'pick_time' => 'required|string',
            'return_time' => 'nullable|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'trip_type' => 'required|in:One Way,Round Trip',
            'offer' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'vehicle_type' => 'required|string',
            'mon' => 'nullable|string|in:on',
            'tue' => 'nullable|string|in:on',
            'wed' => 'nullable|string|in:on',
            'thu' => 'nullable|string|in:on',
            'fri' => 'nullable|string|in:on',
            'sat' => 'nullable|string|in:on',
            'sun' => 'nullable|string|in:on',
            'note' => 'nullable|string',
        ];
    }
}
