<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

/**
 * Class Storage
 *
 * @package Maksi\RequestMapperL
 */
class Storage
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * @param array $map
     */
    public function map(array $map): void
    {
        $this->map = array_merge($this->map, $map);
    }

    /**
     * @return array
     */
    public function getRegisterClass(): array
    {
        return array_keys($this->map);
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
