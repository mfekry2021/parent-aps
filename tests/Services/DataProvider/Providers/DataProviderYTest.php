<?php

namespace Tests\Services\DataProvider\Providers;

use App\Services\DataProvider\Providers\DataProviderY;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class DataProviderYTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetFileName()
    {
        $dataProviderY = new DataProviderY();
        $this->assertEquals('DataProviderY.json', $dataProviderY->getFileName());
    }

    /**
     * @return void
     */
    public function testSetFileName()
    {
        $dataProviderY = new DataProviderY();
        $dataProviderY->setFileName('DataProviderY.json');
        $this->assertEquals('DataProviderY.json', $dataProviderY->getFileName());

    }

    /**
     * @return void
     */
    public function testTransform()
    {
        $dataProviderY = new DataProviderY();
        $data = [
            json_decode(json_encode([
                "id" => "4fc2-a8d1",
                "balance" => 300,
                "currency" => "AED",
                "email" => "parent2@parent.eu",
                "status" => 100,
                "created_at" => "22/12/2018",
            ]))
        ];
        $expected = [
            [
                'id' => '4fc2-a8d1',
                'balance' => 300,
                'currency' => 'AED',
                'email' => 'parent2@parent.eu',
                'status_code' => 1,
                'created_at' => '22/12/2018',
                'provider' => 2
            ]
        ];
        $this->assertEquals($expected, $dataProviderY->transform($data)->toArray());
    }

    /**
     * @return void
     */
    public function testTransformMethodReturnsCollection()
    {
        $dataProviderY = new DataProviderY();
        $data = [
            (object)[
                'id' => '123',
                'balance' => 300,
                'currency' => 'AED',
                'email' => 'parent2@parent.eu',
                'status' => 100,
                'created_at' => '22/12/2018'
            ],
        ];

        $transformedData = $dataProviderY->transform($data);

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
