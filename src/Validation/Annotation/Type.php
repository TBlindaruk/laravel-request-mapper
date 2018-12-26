<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Annotation;

/**
 * Class Type
 *
 * @package Maksi\LaravelRequestMapper\Validation\Annotation
 * @Annotation
 */
final class Type
{
    /**
     * @var string
     */
    private $type;

    private const LARAVEL = 'laravel';
    private const ANNOTATION = 'annotation';

    private const ALLOWED_VALUES = [
        self::ANNOTATION,
        self::LARAVEL,
    ];

    /**
     * Type constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $type = $options['type'] ?? null;
        if (!\in_array($type, self::ALLOWED_VALUES, true)) {
            throw new \InvalidArgumentException('Property "type" is required and should be "annotation" or "laravel"');
        }

        $this->type = $type;
    }

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
