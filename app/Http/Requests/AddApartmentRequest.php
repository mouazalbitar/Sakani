<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'governorate_id' => ['integer', 'required', 'exists:governorates,id', 'exists:cities,govId', 'min:1'],
            'city_id' => [
                'integer',
                'required',
                'exists:cities,id',
                'min:1',
                Rule::exists('cities', 'id')->where(function ($query) {
                    return $query->where('governorate_id', $this->governorate_id);
                })
            ],
            'price' => ['integer', 'min:1'],
            'rooms' => ['integer', 'min:1'],
            'size' => ['integer', 'min:1'],
            'condition' => ['string', 'required', 'in:deluxe,new,normal'],
            'details' => ['string'],
            'img1' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:4096'], //'required', 
            'img2' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:4096'],
            'img3' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:4096']
        ];
    }
}
