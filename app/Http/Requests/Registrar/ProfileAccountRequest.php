<?php

namespace App\Http\Requests\Registrar;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Rules\NotSameAsOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ProfileAccountRequest extends FormRequest
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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',

            'phone_number' => [
                'required',
                'string',
                'min:11',
                'max:11',
                'regex:/^09\d{9}$/',
                Rule::unique('users', 'phone_number')->ignore($this->user()->id),
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/',
                new NotSameAsOldPassword($this->email),
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already taken.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 20 characters.',
            'phone_number.required' => 'The phone number is required.',
            'phone_number.string' => 'The phone number must be a string.',
            'phone_number.min' => 'The phone number must be exactly 11 digits.',
            'phone_number.max' => 'The phone number must be exactly 11 digits.',
            'phone_number.regex' => 'The phone number must start with "09" and be followed by 9 digits.',
            'phone_number.unique' => 'This phone number is already taken.',
        ];
    }

}
