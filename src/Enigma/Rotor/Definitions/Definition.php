<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

use HaeckseSarah\Enigma\Lib\Collection;
use HaeckseSarah\Enigma\Lib\CollectionInterface;

/**
 * Rotor definition.
 */
abstract class Definition implements DefinitionInterface
{
    protected $type = '';
    protected $map;
    protected $pins = [];

    /**
     * get rotor type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * get rotor mapping.
     */
    public function getMap(): CollectionInterface
    {
        return new Collection($this->map);
    }

    /**
     * get rotor pins.
     */
    public function getPins(): CollectionInterface
    {
        return new Collection($this->pins);
    }
}
