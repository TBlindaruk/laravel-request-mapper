# Request Mapper for Laravel

<p align="center">
<a href="https://travis-ci.org/TBlindaruk/laravel-request-mapper"><img src="https://travis-ci.org/TBlindaruk/laravel-request-mapper.svg?branch=master" alt="Build Status"></a>
<a href="https://codecov.io/gh/TBlindaruk/laravel-request-mapper/branch/master"><img src="https://codecov.io/gh/TBlindaruk/laravel-request-mapper/branch/master/graph/badge.svg" alt="Code Coverage"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/license.svg" alt="License"></a>
</p>

This component allow you to inject DTO object mapped from the Request to the action.

1. [Install](#install)
2. [Basic usage](#basic)
3. [Mapped strategies](#mapped-strategies)
4. [Create custom mapped strategy](#custom-mapped-strategy)
5. [How to create an custom exception?](#change-exception)
6. [TODO](#todo)

<a name="install"> <h2>1. Install </h2> </a>

You can install this package via composer using this command:

```
composer require maksi/laravel-request-mapper
```

The package will automatically register itself.


<a name="basic"> <h2>2. Basic usage </h2> </a>

<strong>2.1 Create an DTO object</strong>

```PHP
<?php
declare(strict_types = 1);

use Maksi\LaravelRequestMapper\RequestData\AllRequestData;
use Symfony\Component\Validator\Constraints as Assert;

final class RoomSearchRequestData extends AllRequestData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name; //apply symfony validation for the property
 
    protected function init(array $data): void // $data from the request
    {
        $this->name = $data['name'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
```

Your DTO object should extend one of RequestData classes:
 - [AllRequestData](./src/RequestData/AllRequestData.php)
 - [HeaderRequestData](./src/RequestData/HeaderRequestData.php)
 - [JsonRequestData](./src/RequestData/JsonRequestData.php)

RequestData classes responsible for [mapped strategies](#mapped-strategies). 

You can add validation to the DTO via [`symfony/validator` component](https://symfony.com/doc/current/validation.html).

`$data` array in the `init` it is an `array` from the `$request` object.

<strong>2.2 Inject to the action</strong>

DTO object can be injected to any type of action, this object will be automatically validated by the `sumfony/validator` component, in case if validation are failed, than application will throw [RequestMapperException](./src/Exception/RequestMapperException.php). Exception instance can be changed (for more information please see section [How to create an custom exception](#change-exception))

```PHP
<?php
declare(strict_types = 1);

/**
 * @package App\Http\Controller
 */
class RoomSearchController
{
 ...
    public function __invoke(RoomSearchRequestData $payload) // DTO object injected
    {
        
    }
}

```

<a name="mapped-strategies"> <h2>3.  Mapped strategies </h2> </a>

<a name="custom-mapped-strategy"> <h2>4.  Create custom mapped strategy </h2> </a>

<a name="change-exception"> <h2>5. Change validation exception </h2> </a>

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

2. Define in `config/laravel-request-mapper.php` `exception-class` key

```PHP
<?php
declare(strict_types = 1);

return [
    'exception-class' => \Maksi\LaravelRequestMapper\Exception\StringException::class,
];

```

<a name="todo"> <h2>6. TODO </h2> </a>

- check nested DTO validation
- should add possibility to publish `config` (`readme.md` + `code`)
- change default exception to exception witch can not be implement the Responsable interface  
- contextual binding
- add integration tests for `change exception`
- add tests and documentation for resolving DTO for different actions in diff was (custom strategy with route url detecting)
- add priority to the strategies
- how you can get this DTO from the middleware (should it be singleton?)
- thing about something like substitute binding (inject in some properties in request, and map to the action from them)
- add possibility to switch validation between `laravel` and `symfony`
