<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor;

use HaeckseSarah\Enigma\Rotor\Definitions\DefinitionInterface;

/**
 * Helper functions for creating a rotor.
 */
class RotorFactory
{
    /**
     * create Rotor by definition class.
     */
    public static function createRotorByDefinition(DefinitionInterface $definition, int $ringPosition = 0): RotorInterface
    {
        return new Rotor($definition->getMap(), $definition->getPins(), $definition->getType(), $ringPosition);
    }

    /**
     * create UKW by definition class.
     */
    public static function createUkwByDefinition(DefinitionInterface $definition): UmkehrwalzeInterface
    {
        return new Umkehrwalze($definition->getMap(), $definition->getType());
    }

    public static function createUkwByDefinitionType(string $type): UmkehrwalzeInterface
    {
        $className = 'HaeckseSarah\Enigma\Rotor\Definitions\Ukw\\'.$type;

        return RotorFactory::createUkwByDefinition(new $className());
    }

    public static function createRotorByDefinitionType(string $type, int $ringPos): RotorInterface
    {
        $className = 'HaeckseSarah\Enigma\Rotor\Definitions\\'.$type;

        return RotorFactory::createRotorByDefinition(new $className(), $ringPos - 1);
    }

    public static function createRotorBySettings(RotorSetting $settings): RotorInterface
    {
        return self::createRotorByDefinitionType($settings->getType(), $settings->getRingPosition());
    }
}
