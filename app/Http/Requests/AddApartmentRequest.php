<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class AddApartmentRequest extends FormRequest
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
            'governorate' => ['string', 'required', 'min:3'],
            'city_id' => ['integer', 'required', 'exists:cities,id'],
            'street' => ['string', 'required', 'min:3'],
            'price' => ['integer', 'min:1'],
            'rooms' => ['integer', 'min:1'],
            'size' => ['integer', 'min:1'],
            'condition' => ['string', 'required', 'in:deluxe,new,normal'],
            'img1'=>['string', 'nullable'],
            'img2'=>['string', 'nullable'],
            'img3'=>['string', 'nullable']
        ];
    }
}
