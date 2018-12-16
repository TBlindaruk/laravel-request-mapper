# Request Mapper for Laravel

This component allow you to inject DTO object mapped from the Request to the action.

## How to use?

### Create DTO from the Request

#### Easy way (in case if you want to map data from the $request->all())
You should extend DataTransferObject.php class and define your rules for mapping and validation. Example:

```PHP
<?php
declare(strict_types = 1);

namespace App\Http\RequestData;

use Maksi\RequestMapperL\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TeachersGetRequestData
 *
 * @package App\Http\RequestData
 */
final class RoomSearchRequestData extends DataTransferObject
{
    /**
     * @var string
     *
     * @Assert\NotBlank() 
     * @Assert\Type(type="string")
     */
    private $name; // symfony validation rules append to this

    /**
     * @param array $data it is data from the $request->all();
     */
    public function init(array $data): void
    {
        $this->name = $data['name'] ?? null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
```

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
- check nested DTO validation
- contextual binding
- re-check DTO creating via ServiceProvider define
