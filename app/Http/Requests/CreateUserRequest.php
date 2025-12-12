<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
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
            'phone_number' => ['required', 'unique:users,phone_number', 'digits:10', 'starts_with:0'], //, 'without_spaces'
            'password' => [Password::default(), 'required', 'confirmed', 'string', 'doesnt_start_with:/,$,#,=,(,{,[,-,@,*,~,+,|,!,:,;'],
            'firstName' => ['string', 'required', 'min:3', 'max:25'],
            'lastName' => ['string', 'min:3', 'max:25', 'nullable'],
            'email'=>['nullable', 'email', 'unique:users,email'],
            'city_id' => ['integer', 'required', 'exists:cities,id'],
            'birthday' => ['date_format:Y-m-d', 'date'],
            'photo' => ['image', 'mimes:png,jpg,jpeg,heic', 'max:5120'],
            'id_img' => ['image', 'mimes:png,jpg,jpeg,heic', 'max:5120']
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
