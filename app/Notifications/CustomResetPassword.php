<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('🔐 Reset Your Password')
            ->greeting('Hello ' . ($notifiable->firstname.' '. $notifiable->lastname ?? 'User') . ',')
            ->line('We received a request to reset your password.')
            ->action('Reset Password Now', $resetUrl)
            ->line('This link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no action is required.')
            ->salutation("Best regards,  \nOffice of the Registrar");

    }

}
