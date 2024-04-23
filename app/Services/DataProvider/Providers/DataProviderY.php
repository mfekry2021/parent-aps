<?php

namespace App\Services\DataProvider\Providers;

use App\Enums\DataProvider;
use App\Enums\StatusCode;
use Illuminate\Support\Collection;

class DataProviderY extends AbstractDataProvider
{
    public function __construct()
    {
        $this->setFileName(DataProvider::DataProviderY->getFileName());
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function transform(array $data = []): Collection
    {
        return collect($data)->map(function ($item) {
            return [
                'id' => $item->id,
                'balance' => $item->balance,
                'currency' => strtoupper($item->currency),
                'email' => strtolower($item->email),
                'status_code' => $this->setStatusCode($item->status),
                'created_at' => $item->created_at,
                'provider' => DataProvider::DataProviderY->value
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
            100 => StatusCode::Authorized->value,
            200 => StatusCode::Declined->value,
            300 => StatusCode::Refunded->value
        };
    }
}
