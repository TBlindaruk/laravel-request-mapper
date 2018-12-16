<?php
declare(strict_types = 1);

namespace Tests\Unit;

use Illuminate\Contracts\Config\Repository;
use Maksi\LaravelRequestMapper\Exception\StringException;
use Maksi\LaravelRequestMapper\Validator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\Unit\Stub\AllRequestDataStub;

/**
 * Class ValidatorTest
 *
 * @package Tests\Unit
 */
class ValidatorTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $config;

    /**
     * @var MockObject
     */
    private $errorList;

    /**
     * @var MockObject
     */
    private $symfonyValidator;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->config = $this->getMockBuilder(Repository::class)
//            ->setConstructorArgs()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->symfonyValidator = $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->errorList = $this->getMockBuilder(ConstraintViolationListInterface::class)
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
    }

    /**
     * @throws \Maksi\LaravelRequestMapper\Exception\AbstractException
     * @throws \Maksi\LaravelRequestMapper\Exception\RequestMapperException
     */
    public function testApplyAfterResolvingValidation(): void
    {
        $this->errorList->expects($this->once())->method('count')->willReturn(0);
        $this->symfonyValidator->expects($this->once())->method('validate')->willReturn($this->errorList);

        $validator = $this->createValidator();
        $validator->applyAfterResolvingValidation(new AllRequestDataStub([]));
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Exception\RequestMapperException
     * @throws \Maksi\LaravelRequestMapper\Exception\AbstractException
     * @throws \Maksi\LaravelRequestMapper\Exception\RequestMapperException
     */
    public function testDefaultErrorApplyAfterResolvingValidation(): void
    {
        $this->errorList->expects($this->once())->method('count')->willReturn(1);
        $this->symfonyValidator->expects($this->once())->method('validate')->willReturn($this->errorList);

        $validator = $this->createValidator();
        $validator->applyAfterResolvingValidation(new AllRequestDataStub([]));
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage $class should be instance of
     * @throws \Maksi\LaravelRequestMapper\Exception\AbstractException
     * @throws \Maksi\LaravelRequestMapper\Exception\RequestMapperException
     */
    public function testLogicExceptionApplyAfterResolvingValidation(): void
    {
        $this->config->expects($this->once())->method('get')->willReturn(\InvalidArgumentException::class);
        $this->errorList->expects($this->once())->method('count')->willReturn(1);
        $this->symfonyValidator->expects($this->once())->method('validate')->willReturn($this->errorList);

        $validator = $this->createValidator();
        $validator->applyAfterResolvingValidation(new AllRequestDataStub([]));
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Exception\StringException
     * @throws \Maksi\LaravelRequestMapper\Exception\AbstractException
     * @throws \Maksi\LaravelRequestMapper\Exception\RequestMapperException
     */
    public function testCustomExceptionApplyAfterResolvingValidation(): void
    {
        $this->config->expects($this->once())->method('get')->willReturn(StringException::class);
        $this->errorList->expects($this->once())->method('count')->willReturn(1);
        $this->symfonyValidator->expects($this->once())->method('validate')->willReturn($this->errorList);

        $validator = $this->createValidator();
        $validator->applyAfterResolvingValidation(new AllRequestDataStub([]));
    }

    /**
     * @return Validator
     */
    private function createValidator(): Validator
    {
        return new Validator(
            $this->config,
            $this->symfonyValidator
        );
    }
}
