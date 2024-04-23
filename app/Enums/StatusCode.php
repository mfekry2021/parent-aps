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
            "authorised" => self::Authorized->value,
            "decline" => self::Declined->value,
            "refunded" => self::Refunded->value
        ];
    }
}
