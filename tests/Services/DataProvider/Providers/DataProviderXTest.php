<?php

namespace Tests\Services\DataProvider\Providers;

use App\Services\DataProvider\Providers\DataProviderX;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class DataProviderXTest extends TestCase
{

    /**
     * @return void
     */
    public function testGetFileName()
    {
        $dataProviderY = new DataProviderX();
        $this->assertEquals('DataProviderX.json', $dataProviderY->getFileName());
    }

    /**
     * @return void
     */
    public function testSetFileName()
    {
        $dataProviderY = new DataProviderX();
        $dataProviderY->setFileName('DataProviderX.json');
        $this->assertEquals('DataProviderX.json', $dataProviderY->getFileName());

    }

    /**
     * @return void
     */
    public function testTransform()
    {
        $dataProviderY = new DataProviderX();
        $data = [
            (object)[
                "parentAmount" => 200,
                "Currency" => "USD",
                "parentEmail" => "parent1@parent.eu",
                "statusCode" => 1,
                "registrationDate" => "2018-11-30",
                "parentIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a613"
            ]
        ];
        $expected = [
            [
                'id' => 'd3d29d70-1d25-11e3-8591-034165a3a613',
                'balance' => 200,
                'currency' => 'USD',
                'email' => 'parent1@parent.eu',
                'status_code' => 1,
                'created_at' => '2018-11-30',
                'provider' => 1
            ]
        ];
        $this->assertEquals($expected, $dataProviderY->transform($data)->toArray());
    }

    /**
     * @return void
     */
    public function testTransformMethodReturnsCollection()
    {
        $dataProviderX = new DataProviderX();
        $data = [
            (object)[
                "parentAmount" => 200,
                "Currency" => "USD",
                "parentEmail" => "parent1@parent.eu",
                "statusCode" => 1,
                "registrationDate" => "2018-11-30",
                "parentIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a613"
            ]
        ];

        $transformedData = $dataProviderX->transform($data);

        // Assert that the result is an instance of Collection
        $this->assertInstanceOf(Collection::class, $transformedData);

        // Assert that each item in the transformed data has the expected keys
        foreach ($transformedData as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('balance', $item);
            $this->assertArrayHasKey('currency', $item);
            $this->assertArrayHasKey('email', $item);
            $this->assertArrayHasKey('status_code', $item);
            $this->assertArrayHasKey('created_at', $item);
            $this->assertArrayHasKey('provider', $item);
        }
    }
}
