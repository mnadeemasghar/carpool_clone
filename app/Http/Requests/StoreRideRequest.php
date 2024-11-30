<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        $rules = [
            'phone' => 'nullable|string',
            'role' => 'required|string|in:Driver,Passenger',
            'vehicle_type' => 'required|string|in:Car,Van,Bike',
            'trip_type' => 'required|string|in:One Way,Round Trip',
            'offer' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
            'pick_location' => 'required|string|max:255',
            'pick_time' => 'required',
            'drop_location' => 'required|string|max:255',
            'return_time' => 'required_if:trip_type,Round Trip',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'mon' => 'nullable',
            'tue' => 'nullable',
            'wed' => 'nullable',
            'thu' => 'nullable',
            'fri' => 'nullable',
            'sat' => 'nullable',
            'sun' => 'nullable',
            'days' => 'required_without_all:mon,tue,wed,thu,fri,sat,sun',
            'terms' => 'required|in:on'
        ];

        // Add required rules based on authentication status
        if (!Auth::check()) { // If the user is not logged in
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8';
            $rules['gender'] = 'required|string';
        }

        return $rules;
    }
    
    public function messages()
    {
        return [
            'days.required_without_all' => 'At least one day must be selected.',
            'name.required' => 'Name is required when you are not logged in.',
            'email.required' => 'Email is required when you are not logged in.',
            'password.required' => 'Password is required when you are not logged in.',
        ];
    }
}
