<?php

namespace Tests\Services\Filters;

use App\Enums\DataProvider;
use App\Services\DataProvider\DataProviderReader;
use App\Services\Filters\Filter;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{

    /**
     * @return void
     * @throws Exception
     */
    public function testFilterMethodWithCurrency()
    {
        // Mock DataProviderReader instance
        $mockDataProviderReader = $this->createMock(DataProviderReader::class);

        // Set up a sample dataset
        $data = [
            ['id' => 1, 'currency' => 'USD', 'provider' => 'DataProviderX', 'balance' => 200],
            ['id' => 2, 'currency' => 'EUR', 'provider' => 'DataProviderY', 'balance' => 300],
            // Add more sample data as needed
        ];

        // Set expectations for getData method
        $mockDataProviderReader->expects($this->any())
            ->method('getData')
            ->willReturn(collect($data));

        // Create Filter instance
        $filter = new Filter($mockDataProviderReader);

        // Prepare inputs for filtering by currency
        $inputs = ['currency' => 'USD', 'balanceMin'=>1, 'balanceMax'=>1000];

        // Perform filtering
        $filteredData = $filter->filter($inputs);

        // Assert that the filtered data contains only records with currency 'USD'
        $this->assertCount(1, $filteredData);
        $this->assertEquals(1, $filteredData[0]['id']);
        $this->assertEquals('USD', $filteredData[0]['currency']);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFilterMethodWithProvider()
    {
        // Mock DataProviderReader instance
        $mockDataProviderReader = $this->createMock(DataProviderReader::class);

        // Set up a sample dataset
        $data = [
            ['id' => 1, 'currency' => 'USD', 'provider' => 1, 'balance' => 200],
            ['id' => 2, 'currency' => 'EUR', 'provider' => 2, 'balance' => 300],
            // Add more sample data as needed
        ];

        // Set expectations for getData method
        $mockDataProviderReader->expects($this->any())
            ->method('getData')
            ->willReturn(collect($data));

        // Create Filter instance
        $filter = new Filter($mockDataProviderReader);

        // Prepare inputs for filtering by provider
        $inputs = ['provider' => 'DataProviderX'];

        // Perform filtering
        $filteredData = $filter->filter($inputs);

        // Assert that the filtered data contains only records with provider 'DataProviderX' 1
        $this->assertCount(1, $filteredData);
        $this->assertEquals(1, $filteredData[0]['id']);
        $this->assertEquals(1, $filteredData[0]['provider']);
    }
}
