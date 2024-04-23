<?php

namespace App\Services\DataProvider\Interfaces;

use Illuminate\Support\Collection;

interface DataProviderReaderInterface
{
    /**
     * @return Collection
     */
    public function getData(): Collection;
}
