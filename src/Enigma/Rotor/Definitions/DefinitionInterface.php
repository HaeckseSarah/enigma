<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

/**
 * rotor definition.
 */
interface DefinitionInterface
{
    /**
     * get rotor type.
     */
    public function getType(): string;

    /**
     * get rotor mapping.
     */
    public function getMap(): array;

    /**
     * get rotor pins.
     */
    public function getPins(): array;
}
