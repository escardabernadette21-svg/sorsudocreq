<?php

namespace App\Http\Requests\Registrar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateAnnouncementRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content'  => 'required|string|min:10',
            'status' => 'nullable|in:Active,Inactive', // optional, only allow these values
        ];
    }

    /**
     * Custom Validation Message
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'content.required'  => 'The content is required.',
            'content.min'       => 'The content must be at least 10 characters long.',
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
