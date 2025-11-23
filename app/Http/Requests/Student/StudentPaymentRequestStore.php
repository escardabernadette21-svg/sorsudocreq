<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StudentPaymentRequestStore extends FormRequest
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
            'document_request_id' => 'required|exists:document_requests,id',
            'ref_no' => 'required|string|max:50',
            'studentname' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'receipt' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
    /**
     * Override failed validation to return custom JSON
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 422,
            'error'  => $validator->errors()->toArray()
        ]);

        throw new ValidationException($validator, $response);
    }
}
