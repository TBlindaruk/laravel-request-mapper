<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Annotation;

use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class Type
 *
 * @package Maksi\LaravelRequestMapper\Validation\Annotation
 * @Annotation
 * @Target({"CLASS"})
 */
final class Type
{
    /**
     * @Enum({"laravel", "annotation"})
     * @Required()
     */
    public $type;

    private const LARAVEL = 'laravel';
    private const ANNOTATION = 'annotation';

    /**
     * @return bool
     */
    public function isLaravel(): bool
    {
        return $this->type === self::LARAVEL;
    }

    /**
     * @return bool
     */
    public function isAnnotation(): bool
    {
        return $this->type === self::ANNOTATION;
    }
}
