<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

use HaeckseSarah\Enigma\Lib\CollectionInterface;

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
    public function getMap(): CollectionInterface;

    /**
     * get rotor pins.
     */
    public function getPins(): CollectionInterface;
}
