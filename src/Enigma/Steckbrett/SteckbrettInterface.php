<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Steckbrett;

interface SteckbrettInterface
{
    /**
     * reset Steckbrett.
     */
    public function reset(): void;

    /**
     * add a cable to the steckbrett.
     */
    public function addCable(Cable $cable): void;

    /**
     * get specific cable.
     */
    public function getCableByChar(string $char): ?Cable;

    /**
     * remove cable.
     */
    public function removeCable(Cable $cable): void;

    /**
     * process character trought steckbrett.
     */
    public function __invoke(string $char): string;

    /**
     * convert object to array.
     */
    public function __toArray(): array;

    /**
     * convert object to string.
     */
    public function __toString(): string;
}
