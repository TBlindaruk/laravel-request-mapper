<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class ValidationClass
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\Annotation
 * @Annotation
 * @Target({"CLASS"})
 */
final class ValidationClass
{
    /**
     * @var string
     * @Required()
     */
    public $class;
}
