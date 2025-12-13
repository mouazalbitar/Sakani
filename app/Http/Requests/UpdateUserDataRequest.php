<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserDataRequest extends FormRequest
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
            'phone_number' => ['sometimes', 'unique:users,phone_number', 'digits:10', 'starts_with:0'], //, 'without_spaces'
            'password' => ['sometimes', Password::default(), 'confirmed', 'string', 'doesnt_start_with:/,$,#,=,(,{,[,-,@,*,~,+,|,!,:,;'],
            'firstName' => ['sometimes', 'string', 'min:3', 'max:25'],
            'lastName' => ['sometimes', 'string', 'min:3', 'max:25'],
            'email' => ['sometimes', 'email', 'unique:users,email'],
            'city_id' => ['sometimes', 'integer', 'exists:cities,id'],
            'birthday' => ['sometimes', 'date_format:Y-m-d', 'date'],
            'photo' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,heic', 'max:5120'],
            'id_img' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,heic', 'max:5120']
        ];
    }
}
