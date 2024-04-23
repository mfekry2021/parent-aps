<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Controllers\Api\UsersController;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\ProviderDataResource;
use App\Services\Filters\Filter;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{

    public function testCallable()
    {
        $usersController = new UsersController();
        $this->assertIsCallable($usersController);
    }

    public function testSuccessResponse()
    {
        $response = $this->call("GET", 'api/v1/users', []);
        $content = json_decode($response->content(), true);
        $this->assertEquals(200, $response->status());
    }

    public function testFailResponse()
    {
        $response = $this->call("GET", 'api/v1/users', ["provider"=>'dummy']);
        $content = json_decode($response->content(), true);
        $this->assertEquals(422, $response->status());
    }

    public function testListUserOperation()
    {
        $mockRequest = Mockery::mock(FilterRequest::class);
        $mockFilter = Mockery::mock(Filter::class);
        $mockResourceCollection = Mockery::mock(ProviderDataResource::class);
        // Mock request input data
        $requestData = ['currency' => 'USD'];

        // Expectations for the mock objects
        $mockRequest->shouldReceive('all')->andReturn($requestData);


        $filteredResults = [['id' => 1, 'currency' => 'USD', 'provider' => 1, 'balance' => 200, "email" => 'parent2@parent.eu', 'status_code' => 1, 'created_at' => '2018-12-22']];
        $mockFilter->shouldReceive('filter')->with($requestData)->andReturn($filteredResults);

        $mockResourceCollection->shouldReceive('collection')->with($filteredResults)->andReturn($mockResourceCollection);
        $mockResourceCollection->shouldReceive('response')->andReturn(new JsonResponse($filteredResults));

// Create UsersController instance
        $controller = new UsersController();

        // Invoke the __invoke() method with mock objects
        $response = $controller->__invoke($mockRequest, $mockFilter);
        $this->assertInstanceOf(JsonResponse::class, $response);

    }


}
