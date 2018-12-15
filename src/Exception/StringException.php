<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL\Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * TODO: rename me
 *
 * Class StringException
 *
 * @package Maksi\RequestMapperL\Exception
 */
class StringException extends AbstractException
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
