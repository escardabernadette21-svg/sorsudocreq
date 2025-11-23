<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NotSameAsOldPassword implements Rule
{
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function passes($attribute, $value)
    {
        $user = User::where('email', $this->email)->first();

        if (!$user || !$user->password) {
            return true; // Let other validation handle missing user or password
        }

        // Compare the new password to the old one
        return !Hash::check($value, $user->password);
    }

    public function message()
    {
        return 'The new password must be different from your old password.';
    }
}
