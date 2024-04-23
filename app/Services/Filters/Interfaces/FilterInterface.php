<?php

namespace App\Services\Filters\Interfaces;

interface FilterInterface
{
    /**
     * @param array $inputs
     * @return array
     */
    public function filter(array $inputs): array;
}
