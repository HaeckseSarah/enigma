<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Walzenwerk;

use HaeckseSarah\Enigma\Rotor\RotorInterface;

/**
 * Walzenwerk
 * combines ETW, Rotors and UKW.
 */
interface WalzenwerkInterface
{
    public const WW_ROTATION_OFF = 0;
    public const WW_ROTATION_SIMPLE = 1;
    public const WW_ROTATION_DOUBLESTEP = 3;

    /**
     * rotate specific rotor.
     */
    public function setRotorPosition(int $rotorIndex, int $position): void;

    /**
     * rotate specific rotor.
     */
    public function moveRotor(int $rotorIndex, int $steps): void;

    /**
     * replace rotor.
     */
    public function replaceRotor(int $rotorIndex, RotorInterface $rotor): void;

    /**
     * process character.
     */
    public function __invoke(string $char, int $rotationMode = self::WW_ROTATION_DOUBLESTEP): string;

    /**
     * convert object to array.
     */
    public function __toArray(): array;

    /**
     * convert object to string.
     */
    public function __toString(): string;
}
