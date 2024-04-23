<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\ProviderDataResource;
use App\Services\Filters\Filter;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    /**
     * @param FilterRequest $request
     * @param Filter $filter
     * @return JsonResponse
     */
    public function __invoke(FilterRequest $request, Filter $filter): JsonResponse
    {
        $results = $filter->filter($request->all());
        return response()->json(ProviderDataResource::collection($results));

    }
}
