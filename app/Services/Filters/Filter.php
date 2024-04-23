<?php

namespace App\Services\Filters;

use App\Enums\DataProvider;
use App\Services\DataProvider\DataProviderReader;
use App\Services\Filters\Interfaces\FilterInterface;

class Filter implements FilterInterface
{
    /**
     * @param DataProviderReader $dataProviderReader
     */
    public function __construct(protected DataProviderReader $dataProviderReader)
    {
    }

    /**
     * @param array $inputs
     * @return array
     */
    public function filter(array $inputs): array
    {
        $data = $this->dataProviderReader->getData();
        return $data
            ->when(!empty($inputs['currency']), function ($query) use ($inputs) {
                return $this->filterByCurrency(query: $query, currency: $inputs['currency']);
            })->when(!empty($inputs['provider']), function ($query) use ($inputs) {
                return $this->filterByProvider(query: $query, provider: $inputs['provider']);
            })->when(!empty($inputs['balanceMin']), function ($query) use ($inputs) {
                return $this->filterByMinBalance(query: $query, balance: $inputs['balanceMin']);
            })->when(!empty($inputs['balanceMax']), function ($query) use ($inputs) {
                return $this->filterByMaxBalance(query: $query, balance: $inputs['balanceMax']);
            })->all();
    }

    /**
     * @param $query
     * @param string $currency
     * @return mixed
     */
    private function filterByCurrency($query, string $currency): mixed
    {
        return $query->where('currency', $currency);
    }

    /**
     * @param $query
     * @param string $provider
     * @return mixed
     */
    private function filterByProvider($query, string $provider): mixed
    {
        return $query->where('provider', DataProvider::getNames()[$provider]);
    }

    /**
     * @param $query
     * @param float $balance
     * @return mixed
     */
    private function filterByMinBalance($query, float $balance): mixed
    {
        return $query->where('balance', '>=', $balance);
    }

    /**
     * @param $query
     * @param float $balance
     * @return mixed
     */
    private function filterByMaxBalance($query, float $balance): mixed
    {
        return $query->where('balance', '<=', $balance);
    }
}
