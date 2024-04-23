<?php

namespace App\Services\DataProvider\Providers;

use App\Enums\DataProvider;
use App\Enums\StatusCode;
use Illuminate\Support\Collection;

class DataProviderX extends AbstractDataProvider
{
    public function __construct()
    {
        $this->setFileName(DataProvider::DataProviderX->getFileName());
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function transform(array $data = []): Collection
    {
        return collect($data)->map(function ($item) {
            return [
                'id' => $item->parentIdentification,
                'balance' => $item->parentAmount,
                'currency' => strtoupper($item->Currency),
                'email' => strtolower($item->parentEmail),
                'status_code' => $this->setStatusCode($item->statusCode),
                'created_at' => $item->registrationDate,
                'provider' => DataProvider::DataProviderX->value
            ];
        });
    }

    /**
     * @param int $statusCode
     * @return int
     */
    private function setStatusCode(int $statusCode): int
    {
        return match ($statusCode) {
            1 => StatusCode::Authorized->value,
            2 => StatusCode::Declined->value,
            3 => StatusCode::Refunded->value
        };
    }
}
