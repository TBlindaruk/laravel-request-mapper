# Request Mapper for Laravel

This component allow you to inject DTO object mapped from the Request to the action.

## How to use?

### Change rendering of the exception

1. Create Exception which will extend /Exception/AbstractException.php and implement toResponse method

For example:

```PHP
<?php

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
```

2. Define in config/request-mapper-l.php exception-class key

```PHP
<?php
declare(strict_types = 1);

return [
    'exception-class' => \Maksi\RequestMapperL\Exception\StringException::class,
];

```

## Todo
- contextual binding


