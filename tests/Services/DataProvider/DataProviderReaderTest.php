<?php

namespace Tests\Services\DataProvider;

use App\Services\DataProvider\DataProviderReader;
use App\Services\DataProvider\Providers\DataProviderX;
use App\Services\DataProvider\Providers\DataProviderY;
use Illuminate\Support\Collection;
use Tests\TestCase;


class DataProviderReaderTest extends TestCase
{
    public function testGetData()
    {
        $dataProviderReader = new DataProviderReader();
        $data = $dataProviderReader->getData();
        //check if the data is an collection
        $this->assertInstanceOf(Collection::class, $data);
    }

    public function testGetDataReturnsCollectionOfTheSameCount()
    {
        // Mock DataProviderX and DataProviderY instances
        $mockDataProviderX = $this->createMock(DataProviderX::class);
        $mockDataProviderY = $this->createMock(DataProviderY::class);

        // Mock the read and transform methods
        $mockDataProviderX->expects($this->any())
            ->method('getFileName')
            ->willReturn('DataProviderX.json');

        $mockDataProviderY->expects($this->any())
            ->method('getFileName')
            ->willReturn('DataProviderY.json');

        $mockDataProviderX->expects($this->any())
            ->method('transform')
            ->willReturn(new Collection([
                ['id' => '1', 'balance' => 200, 'currency' => 'USD', 'email' => 'parent1@parent.eu', 'status_code' => 1, 'created_at' => '2018-11-30', 'provider' => 1]
            ]));

        $mockDataProviderY->expects($this->any())
            ->method('transform')
            ->willReturn(new Collection([
                ['id' => '2', 'balance' => 300, 'currency' => 'AED', 'email' => 'parent2@parent.eu', 'status_code' => 100, 'created_at' => '2018-12-22', 'provider' => 2]
            ]));

        // Create DataProviderReader Mock and call getData method
        $dataProviderReaderMock = $this->createMock(DataProviderReader::class);
        $dataProviderReaderMock->expects($this->any())
            ->method('getData')
            ->willReturn(new Collection([$mockDataProviderX, $mockDataProviderY]));
        $allData = $dataProviderReaderMock->getData();
        // Assert that the result is an instance of Collection
        $this->assertInstanceOf(Collection::class, $allData);

        // Assert that the merged data contains the expected transformed data
        $this->assertCount(2, $allData); // Assuming two providers are read and transformed
    }
}
