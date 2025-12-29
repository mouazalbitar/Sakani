<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'apartment_id' => [$this->isMethod('post') ? 'required' : 'nullable', 'integer', 'exists:apartments,id', 'min:1'],
            'start_date' => ['required', 'date_format:Y-m-d', 'date', 'after:today', 'before:' . now()->addMonths(3)->format('Y-m-d')],
            'end_date' => ['required', 'date_format:Y-m-d', 'date', 'after:start_date'],
            'payment_details' => ['nullable'],
        ];
    }
    public function messages()
    {
        return [
            'birthday.date_format' => 'Incorrect Formate, Should be YYYY-MM-DD like 2000-01-01',
            'birthday.date' => 'The birthday field must be a valid date.'
        ];
    }
}
