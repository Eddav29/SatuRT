<?php

namespace App\Services\Interfaces;

use Illuminate\Notifications\Notification;

interface EmailServiceInterface
{
    public function sendEmail(string $email, string $subject, string $message): Notification;

    public function sendEmailWithAttachment(string $email, string $subject, string $message, string $attachment): Notification;

}

