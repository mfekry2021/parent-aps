<?php

namespace App\Services\DataProvider\Providers;

use App\Services\DataProvider\Interfaces\DataProviderInterface;

abstract class AbstractDataProvider implements DataProviderInterface
{
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return void
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }
}
