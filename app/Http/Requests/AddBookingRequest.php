<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'apertment_id' => ['required', 'integer', 'exists:apartments:id'],
            'tenant_id' => ['required', 'integer', 'exists:users:id'],
            'start' => ['required', 'date_format:Y-m-d', 'date'],
            'end' => ['required', 'date_format:Y-m-d', 'date'],
            'payment_details' => ['nullable'],
            'booking_status' => ['nullable', 'in:approved,canceled,pending']
        ];
    }
    public function messages()
    {
        return [
            'birthday.date_format'=>'Incorrect Formate, Should be YYYY-MM-DD like 2000-01-01',
            'birthday.date'=>'The birthday field must be a valid date.'
        ];
    }
}
