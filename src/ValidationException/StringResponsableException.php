<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\ValidationException;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class StringResponsableException
 *
 * @package Maksi\LaravelRequestMapper\ValidationException
 */
class StringResponsableException extends AbstractException implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return JsonResponse::create('Invalid data provided')->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
