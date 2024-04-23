<?php

namespace App\Enums;

enum StatusCode: int
{
    case Authorized = 1;
    case Declined = 2;
    case Refunded = 3;

    public static function getNames(): array
    {
        return [
            "authorised" => self::Authorized,
            "decline" => self::Declined,
            "refunded" => self::Refunded
        ];
    }
}
