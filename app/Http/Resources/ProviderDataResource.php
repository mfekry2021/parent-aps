<?php

namespace App\Http\Resources;

use App\Enums\DataProvider;
use App\Enums\StatusCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this['id'],
            'email' => (string)$this['email'],
            'balance' => (float)$this['balance'],
            'currency' => (string)$this['currency'],
            'statusCode' => StatusCode::tryFrom($this['status_code'])->name,
            'created_at' => (string)$this['created_at'],
            'provider' => DataProvider::tryFrom($this['provider'])->name,
        ];
    }
}
