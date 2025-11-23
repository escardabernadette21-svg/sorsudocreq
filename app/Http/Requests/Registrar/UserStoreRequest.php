<?php

namespace App\Http\Requests\Registrar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class UserStoreRequest extends FormRequest
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
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif', // Max size 2MB
            // 'student_id' => 'required|unique:users,student_id',
            'student_id'      => [
                                    'required',
                                    'unique:users,student_id',
                                    'regex:/^[0-9\-]+$/'

                                    // 'regex:/^(?=.*-)[0-9-]+$/',
                                ],
            'student_type' => 'required',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone_number' => [
                'required',
                'string',
                'min:11',
                'max:11',
                'regex:/^09\d{9}$/',
                'unique:users,phone_number'
            ],

            'year'            => 'nullable|string|required_if:student_type,enrolled|required_without:batch_year|max:255',
            'batch_year'  => 'nullable|digits:4|integer|min:1900|max:' . date('Y') . '|required_if:student_type,alumni|required_without:year',
            'course' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/',
            ]

        ];
    }
    public function messages()
    {
        return [
            'student_id.regex' => 'Student ID may only contain numbers and an optional dash (e.g., 123456 or 12-3456).',
            'email.unique' => 'This email is already taken.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 20 characters.',

            // Phone number validation messages
            'phone_number.required' => 'The phone number is required.',
            'phone_number.string' => 'The phone number must be a string.',
            'phone_number.min' => 'The phone number must be exactly 11 digits.',
            'phone_number.max' => 'The phone number must be exactly 11 digits.',
            'phone_number.regex' => 'The phone number must start with "09" and be followed by 9 digits.',
            'phone_number.unique' => 'This phone number is already taken.',
        ];
    }

     /**
     * Override failed validation to return custom response.
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 422,
            'error' => $validator->errors()->toArray()
        ]);

        throw new ValidationException($validator, $response);
    }
}
