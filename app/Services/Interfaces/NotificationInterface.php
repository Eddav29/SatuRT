<?php

namespace App\Services\Interfaces;


interface NotificationInterface
{
    public static function success(string $message): void;

    public static function error(string $message): void;

    public static function warning(string $message): void;
}
