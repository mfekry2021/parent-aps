<?php

namespace App\Http\Requests;

use App\Enums\DataProvider;
use App\Enums\StatusCode;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'provider' => 'nullable|in:' . implode(',',array_keys(DataProvider::getNames())),
            'balanceMin' => 'nullable|numeric',
            'balanceMax' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'statusCode' => 'nullable|in:' . implode(',',array_keys(StatusCode::getNames())),
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        $response = ["message" => $validator->errors()->first()];
        throw new HttpResponseException(response($response, ResponseAlias::HTTP_UNPROCESSABLE_ENTITY));
    }
}
