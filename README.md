# Request Mapper for Laravel

<p align="center">
<a href="https://travis-ci.org/TBlindaruk/laravel-request-mapper"><img src="https://travis-ci.org/TBlindaruk/laravel-request-mapper.svg?branch=master" alt="Build Status"></a>
<a href="https://codecov.io/gh/TBlindaruk/laravel-request-mapper/branch/master"><img src="https://codecov.io/gh/TBlindaruk/laravel-request-mapper/branch/master/graph/badge.svg" alt="Code Coverage"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/license.svg" alt="License"></a>
</p>

This component allow you to inject DTO object mapped from the Request to the action.

## 1. How to use?

### 1.1. Create DTO from the Request

#### 1.1.1 Easy way (in case if you want to map data from the $request->all())
You should extend DataTransferObject.php class and define your rules for mapping and validation. Example:

```PHP
<?php
declare(strict_types = 1);

namespace App\Http\RequestData;

use Maksi\RequestMapperL\RequestData;
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

#### 1.1.2 Configure DTO parameter in the construct via ServiceProvider

```PHP
<?php
declare(strict_types = 1);

namespace App\Http;

use Illuminate\Http\Request;
use Maksi\RequestMapperL\Support\RequestMapperServiceProvider;

/**
 * Class RequestMapperProvider
 *
 * @package App\Http
 */
class RequestMapperProvider extends RequestMapperServiceProvider
{
    /**
     * @param Request $request
     *
     * @return array
     */
    protected function resolveMap(Request $request): array
    {
        return [
            RoomSearchRequestData::class => $request->all(), // RoomSearchRequestData DTO class
        ];
    }
}

```


### 1.2. Change rendering of the exception

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

## 1.3. Todo
- check nested DTO validation
- contextual binding
- add integration tests for `change exception`
- add tests and documentation for resolving DTO for different actions in diff was (custom strategy with route url detecting)
- add priority to the strategies
- how you can get this DTO from the middleware (should it be singleton?)
- thing about something like substitute binding (inject in some properties in request, and map to the action from them)
- add possibility to switch validation between `laravel` and `symfony`  
