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
3. [Nested object](#nested)
4. [Mapped strategies](#mapped-strategies)
5. [Create custom mapped strategy](#custom-mapped-strategy)
6. [How to create an custom exception?](#change-exception)
7. [TODO](#todo)

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

DTO object can be injected to any type of action, this object will be automatically validated by the `sumfony/validator` component, in case if validation are failed, than application will throw [JsonResponsableException](src/ValidationException/JsonResponsableException.php). Exception instance can be changed (for more information please see section [How to create an custom exception](#change-exception))

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
<a name="nested"> <h2>3.  Nested object </h2> </a>

In the same way you can create an nested DTO object, <strong> for example: </strong>

<p align="center"><i>Root class</i></p>

```PHP
<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub\NestedRequestData;

use Maksi\LaravelRequestMapper\RequestData\JsonRequestData;
use Symfony\Component\Validator\Constraints as Assert;

class RootRequestDataStub extends JsonRequestData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $title;

    /**
     * @Assert\Valid()
     */
    private $nested; // this property should have `Valid` annotation for validate nested object

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->title = $data['title'] ?? null;
        $this->nested = new NestedRequestDataStub($data['nested'] ?? []);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNested(): NestedRequestDataStub
    {
        return $this->nested;
    }
}

```

<p align="center"><i>Nested class</i></p>

```PHP
<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub\NestedRequestData;

use Maksi\LaravelRequestMapper\RequestData\JsonRequestData;
use Symfony\Component\Validator\Constraints as Assert;

class NestedRequestDataStub extends JsonRequestData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $nestedTitle;

    protected function init(array $data): void
    {
        $this->nestedTitle = $data['title'] ?? null;
    }

    public function getTitle(): string
    {
        return $this->nestedTitle;
    }
}

```


<a name="mapped-strategies"> <h2>4.  Mapped strategies </h2> </a>

<a name="custom-mapped-strategy"> <h2>5.  Create custom mapped strategy </h2> </a>

<a name="change-exception"> <h2>6. Change validation exception </h2> </a>

1. Create Exception which will extend /Exception/AbstractException.php and implement toResponse method

For example:

```PHP
<?php

class StringException extends \Maksi\LaravelRequestMapper\ValidationException\AbstractException
                                implements \Illuminate\Contracts\Support\Responsable
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
        return \Illuminate\Http\JsonResponse::create('Invalid data provided')
                            ->setStatusCode(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
```

2. Define in `config/laravel-request-mapper.php` `exception-class` key

```PHP
<?php
declare(strict_types = 1);

return [
    'exception-class' => \Maksi\LaravelRequestMapper\ValidationException\DefaultException::class,
];

```

<a name="todo"> <h2>7. TODO </h2> </a>

- [ ] should add possibility to publish `config` (`readme.md` + `code`)
- [ ] contextual binding
- [ ] add integration tests for `change exception`
- [ ] add tests and documentation for resolving DTO for different actions in diff was (custom strategy with route url detecting)
- [ ] add priority to the strategies
- [ ] how you can get this DTO from the middleware (should it be singleton?)
- [ ] thing about something like substitute binding (inject in some properties in request, and map to the action from them)
- [ ] add possibility to switch validation between `laravel` and `symfony`
- [ ] add codecov separate for `unit` and `integration` tests
