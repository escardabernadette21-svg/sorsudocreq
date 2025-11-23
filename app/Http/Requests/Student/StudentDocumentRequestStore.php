<?php

namespace App\Http\Requests\Student;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StudentDocumentRequestStore extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'studentname'        => 'required|string|max:255',
            'student_id'         => 'required|string|max:50',
            'student_type'       => 'required',
            'year'               => 'nullable|string|max:50',
            'year_graduated'     => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            // 'course'          => 'required|string|max:255',
            // 'request_date'    => ['required', 'date', function ($attribute, $value, $fail) { ... }],
            'certifications'     => 'array',
            'cert_qty'           => 'array',
            'academic_forms'     => 'array',
            'academic_qty'       => 'array',
            'other_services'     => 'array',
            'other_services_qty' => 'array',
            'credentials'        => 'array', // <-- Credential's Fee items
            'credentials_qty'    => 'array', // <-- quantities for each credential
            'purpose'            => 'required|string|max:255',
            'message'            => 'nullable|string|max:1000',
        ];
    }

    /**
     * After basic validation, apply custom validation rule
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $certifications = $this->input('certifications', []);
            $academic_forms = $this->input('academic_forms', []);
            $other_services = $this->input('other_services', []);
            $credentials = $this->input('credentials', []); // check credentials

            if (empty($certifications) && empty($academic_forms) && empty($other_services) && empty($credentials)) {
                $validator->errors()->add('documents', 'Please select at least one document (certification, academic form, other service, or credential).');
            }
        });
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
