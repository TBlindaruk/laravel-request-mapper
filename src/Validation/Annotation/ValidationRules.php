<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class ValidationRules
 * @package Maksi\LaravelRequestMapper\Validation\Annotation
 * @Annotation
 * @Target({"CLASS"})
 */
final class ValidationRules
{
    /**
     * @var string
     * @Required()
     */
    public $class;
}
