<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

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
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * get rotor pins.
     */
    public function getPins(): array
    {
        return $this->pins;
    }
}
