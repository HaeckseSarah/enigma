<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor;

interface UmkehrwalzeInterface
{
    /**
     * get Rotator Type.
     */
    public function getType(): string;

    /**
     * process character from left to right.
     */
    public function __invoke(int $index): int;

    /**
     * convert object to array.
     */
    public function __toArray(): array;

    /**
     * convert object to string.
     */
    public function __toString(): string;
}
