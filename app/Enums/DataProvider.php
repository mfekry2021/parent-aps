<?php

namespace App\Enums;

use App\Services\DataProvider\Providers\DataProviderX;
use App\Services\DataProvider\Providers\DataProviderY;

enum DataProvider: int
{
    case DataProviderX = 1;
    case DataProviderY = 2;

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return match ($this) {
            self::DataProviderX => 'DataProviderX.json',
            self::DataProviderY => 'DataProviderY.json',
        };
    }

    public static function getNames(): array
    {
        return [
            "DataProviderX"=> self::DataProviderX->value,
            "DataProviderY"=> self::DataProviderY->value
        ];
    }

    /**
     * @return string[]
     */
    public static function getReadableClasses(): array
    {
        return [
            DataProviderX::class,
            DataProviderY::class
        ];
    }
}
