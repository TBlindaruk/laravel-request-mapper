# Request Mapper for Laravel

<p align="center">
<a href="https://travis-ci.org/TBlindaruk/laravel-request-mapper"><img src="https://travis-ci.org/TBlindaruk/laravel-request-mapper.svg?branch=master" alt="Build Status"></a>
<a href="https://codecov.io/gh/TBlindaruk/laravel-request-mapper/branch/master"><img src="https://codecov.io/gh/TBlindaruk/laravel-request-mapper/branch/master/graph/badge.svg" alt="Code Coverage"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/maksi/laravel-request-mapper"><img src="https://poser.pugx.org/maksi/laravel-request-mapper/license.svg" alt="License"></a>
</p>

This component allow you to inject DTO object mapped from the Request to the action.

1. [Install](#install)
2. [Requirements](#requirements)
3. [Basic usage](#basic)
4. [Nested object](#nested)
5. [Mapped strategies](#mapped-strategies)
6. [Create custom mapped strategy](#custom-mapped-strategy)
7. [How to create an custom exception?](#change-exception)
8. [Project example](#example)
9. [Contributing](#contributing)
10. [Licence](#licence)
11. [TODO](#todo)

<a name="install"> <h2>1. Install </h2> </a>

You can install this package via composer using this command:

```
composer require maksi/laravel-request-mapper
```

The package will automatically register itself.

<a name="requirements"> <h2>2. Requirements </h2> </a>

PHP 7.1 or newer and Laravel 5.5 or newer

<a name="basic"> <h2>3. Basic usage </h2> </a>

<strong>3.1 Create an DTO object</strong>

```PHP
<?php
declare(strict_types = 1);

use Maksi\LaravelRequestMapper\Filling\RequestData\AllRequestData;

final class RoomSearchRequestData extends AllRequestData
{
    private $name;
 
    protected function init(array $data): void
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
 - [AllRequestData](./src/Filling/RequestData/AllRequestData.php)
 - [HeaderRequestData](./src/Filling/RequestData/HeaderRequestData.php)
 - [JsonRequestData](./src/Filling/RequestData/JsonRequestData.php)

RequestData classes responsible for [mapped strategies](#mapped-strategies). 

`$data` array in the `init` it is an `array` which return from the [mapped strategies](#mapped-strategies) classes.  <strong> Basically `$data` it is some data from the `Request`. </strong>

<strong>3.2 Inject to the action</strong>

DTO object can be injected to any type of action.

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

<strong>3.3 Validate DTO object</strong>

You can apply validation to the DTO object:
- before mapping data to the DTO (`laravel` validation)
- after mapping data to the DTO (`symfony annotation` validation)

<strong>3.3.1 Apply laravel validation </strong>

<i> Laravel validation applied for the `RequestData` object before object filling. </i> 

1. You should create a class with validation rules. This class should implement `Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\ValidationRuleInterface` interface (in case, if you do no need change the validation `messages` and `customAttributes`, than you can extend `Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\AbstractValidationRule` class)

```PHP
<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\AbstractValidationRule;

class ValidatorRule extends AbstractValidationRule
{
    public function rules(): array
    {
        return [
            'nested' => 'array|required',
            'title' => 'string|required',
        ];
    }
}

```

2. In the next you should apply this rules to the DTO object. This should be done via `annotation`.

```PHP
<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\Annotation\ValidationClass;

/**
 * @ValidationClass(class="\Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub\ValidatorRule")
 */
class RootRequestDataStub extends JsonRequestData
{
    private $title;

    private $nested;

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

string

```PHP
@ValidationClass(class="\Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub\ValidatorRule")
```

indicates that <string>before</string> filling current DTO should be appied `\Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub\ValidatorRule` rules for the `data` which will be injected to the dto.

<strong>3.3.2 Apply symfony annotation validation </strong>

Annotation symfony validation applied to the properties in the `RequestData` object (So this validation appied after the creating and DTO object).

At the first you should add the `@Type(type="annotation")` annotation to the RequestData object. After this you can apply the validation to the DTO object (for more information please see symfony [validation documentation](https://symfony.com/doc/current/validation.html))

```PHP
<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\AllRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Type(type="annotation")
 */
class AllRequestDataStub extends AllRequestData
{
    /**
     * @Assert\Type(type="int")
     * @Assert\NotBlank()
     */
    private $allAge;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $allTitle;

    protected function init(array $data): void
    {
        $this->allAge = $data['age'] ?? null;
        $this->allTitle = $data['title'] ?? null;
    }

    public function getAllTitle(): string
    {
        return $this->allTitle;
    }

    public function getAllAge(): int
    {
        return $this->allAge;
    }
}

```

<a name="nested"> <h2>4. Nested object validation </h2> </a>

<strong> 4.1. Symfony annotation validation</strong>

In the same way you can create an nested DTO object, <strong> for example: </strong>

<p align="center"><i>Root class</i></p>

```PHP
<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Type(type="annotation")
 */
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

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
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

<strong> 4.2. Laravel validation for nested</strong>

So, as a laravel validation applied before filling the `RequestData` object, than you should just create the same validation class as an for no nested validation.

```PHP
<?php
use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\AbstractValidationRule;

class ValidatorRule extends AbstractValidationRule
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nested' => 'array|required',
            'title' => 'string|required',
            'nested.title' => 'string|required', // nested object validation
        ];
    }
}
```

<a name="mapped-strategies"> <h2>5.  Mapped strategies </h2> </a>

By default package has 3 strategies:
- [AllStrategy](./src/Filling/Strategies/AllStrategy.php)
- [HeaderStrategy](./src/Filling/Strategies/HeaderStrategy.php)
- [JsonStrategy](./src/Filling/Strategies/JsonStrategy.php)

<strong> AllStrategy </strong> - responsible for filling data from the `$request->all()` array. If ou want to use this strategy, than your `RequestData` object should extend `AllRequestData` class.

<strong> HeaderStrategy </strong> - responsible for filling data from the `$request->header->all()` array. If ou want to use this strategy, than your `RequestData` object should extend `HeaderRequestData` class.

<strong> JsonStrategy </strong> - responsible for filling data from the `$request->json()->all()` array. If ou want to use this strategy, than your `RequestData` object should extend `JsonRequestData` class.

<a name="custom-mapped-strategy"> <h2>6.  Create custom mapped strategy </h2> </a>

You can create a custom mapped strategies for our application.

<strong>6.1 Create custom strategy </strong>

You strategy should implement [StrategyInterface](./src/Filling/Strategies/StrategyInterface.php);

```PHP
<?php
declare(strict_types = 1);

namespace App\Http\RequestDataStrategy;

use App\Http\RequestData\TeacherSearchRequestData;
use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Filling\Strategies\StrategyInterface;
use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;

class TeacherSearchStrategy implements StrategyInterface
{
    public function resolve(Request $request): array
    {
        return $request->all();
    }

    public function support(Request $request, RequestData $object): bool
    {
        return $object instanceof TeacherSearchRequestData
            && $request->routeIs('teacher-search');

    }
}
```

Method `support` define is strategy available for `resolve` object. This method has 2 parameters `$request` and `$object`:
- `$request` as a `Request` instance
- <strong>`$object`</strong> - it is empty DTO instance, witch will be filled

Method `resolve` will return the array which will be injected to the DTO instance. This method accept `$request` object.

<strong>6.2 Create RequestData class for Strategy</strong>

You should extend  <strong>[RequestData](./src/Filling/RequestData/RequestData.php) in case if you want to create your own strategy</strong>


```PHP
<?php
declare(strict_types = 1);

namespace App\Http\RequestData;

use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;
use Symfony\Component\Validator\Constraints as Assert;

final class TeacherSearchRequestData extends RequestData
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name;

    protected function init(array $data): void
    {
        $this->name = $data['name'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
```

<strong>6.3 Register your strategy in the `ServiceProvider` </strong>

You should add instance of your `strategy` to the `Maksi\LaravelRequestMapper\StrategiesHandler` via `addStrategy` method.

```PHP
<?php
declare(strict_types = 1);

namespace App\Http\Provider;

use App\Http\RequestDataStrategy\TeacherSearchStrategy;
use Illuminate\Support\ServiceProvider;
use Maksi\LaravelRequestMapper\FillingChainProcessor;

/**
 * Class RequestMapperProvider
 *
 * @package App\Http\Provider
 */
class RequestMapperProvider extends ServiceProvider
{
    /**
     * @param FillingChainProcessor $fillingChainProcessor
     */
    public function boot(FillingChainProcessor $fillingChainProcessor): void
    {
        $fillingChainProcessor->addStrategy($this->app->make(TeacherSearchStrategy::class));
    }
}

```


<a name="change-exception"> <h2>7. Change validation exception </h2> </a>

1. Create Exception which will extend `\Maksi\LaravelRequestMapper\Validation\ResponseException\AbstractException` and implement toResponse method

For example:

```PHP
<?php

class StringException extends \Maksi\LaravelRequestMapper\Validation\ResponseException\AbstractException
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
    'exception-class' => \Maksi\LaravelRequestMapper\Validation\ResponseException\DefaultException::class,
];

```

<a name="example"> <h2>8. Project example </h2> </a>

You can see example of usage part of this package in https://github.com/E-ZSTU/rozklad-rest-api project. 

<a name="contributing"> <h2> Contributing </h2> </a>

Please see [CONTRIBUTING](./CONTRIBUTING.md) for details.

<a name="license"> <h2> License </h2> </a>

The MIT License (MIT). Please see [License](./LICENSE) File for more information.

<a name="todo"> <h2>TODO </h2> </a>

- [ ] add integration tests for `change exception`
- [ ] add priority to the strategies
- [ ] how you can get this DTO from the middleware (just register `RequestData` as a singleton)
