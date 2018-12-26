<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\ResponseException;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class JsonResponsableException
 *
 * @package Maksi\LaravelRequestMapper\Validation\ResponseException
 */
class JsonResponsableException extends AbstractException implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $result = [];

        $errors = $this->errorCollection ? $this->errorCollection->all() : [];

        foreach ($errors as $value) {
            // TODO: Add tests for this lines (inside loop)
            $localResult = [];
            $localResult['message'] = $value->getMessage();
            $localResult['property'] = $value->getProperty();

            $result[] = $localResult;
        }

        return JsonResponse::create(['errors' => $result])->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
