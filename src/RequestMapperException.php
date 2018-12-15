<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Class RequestMapperException
 *
 * @package App\Framework\RequestMapper
 */
class RequestMapperException extends Exception implements Responsable
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    /**
     * RequestMapperException constructor.
     *
     * @param ConstraintViolationListInterface $constraintViolationList
     * @param string                           $message
     * @param int                              $code
     * @param Throwable|null                   $previous
     */
    public function __construct(
        ConstraintViolationListInterface $constraintViolationList,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }

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

        /** @var ConstraintViolation $value */
        foreach ($this->constraintViolationList as $value) {
            $localResult = [];
            $localResult['message'] = $value->getMessage();
            $localResult['property'] = $value->getPropertyPath();
            $localResult['given'] = $value->getInvalidValue();

            $result[] = $localResult;
        }

        return JsonResponse::create($result)->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
