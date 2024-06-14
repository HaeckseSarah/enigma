<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor;

/**
 * Single Rotor.
 */
interface RotorInterface extends \Iterator, \ArrayAccess
{
    /**
     * get Rotator Type.
     */
    public function getType(): string;

    /**
     * set current rotation.
     */
    public function setOffset(int $offset): void;

    /**
     * Move rotor x steps.
     */
    public function move(int $steps): void;

    /**
     * check, if current rotation has a pin, to move forward next rotor.
     *
     * @param int $offset check for pin relatively
     */
    public function isPin($offset = 0): bool;

    /**
     * convert object to array.
     */
    public function __toArray(): array;

    /**
     * convert object to string.
     */
    public function __toString(): string;
}
