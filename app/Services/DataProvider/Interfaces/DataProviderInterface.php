<?php

namespace App\Services\DataProvider\Interfaces;

use Illuminate\Support\Collection;

interface DataProviderInterface
{
    /**
     * @return string
     */
    public function getFileName(): string;

    /**
     * @param string $fileName
     * @return void
     */
    public function setFileName(string $fileName): void;

    /**
     * @param array $data
     * @return Collection
     */
    public function transform(array $data = []): Collection;
}
