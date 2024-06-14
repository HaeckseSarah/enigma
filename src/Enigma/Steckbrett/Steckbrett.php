<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Steckbrett;

use HaeckseSarah\Enigma\Exception\InvalidCableException;
use HaeckseSarah\Enigma\Lib\Collection;

/**
 * Steckbrett.
 */
class Steckbrett implements SteckbrettInterface
{
    protected $cables;
    protected $cableMap;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * reset Steckbrett.
     */
    public function reset(): void
    {
        $this->cables = new Collection();
        $this->cableMap = new Collection();
    }

    /**
     * add a cable to the steckbrett.
     */
    public function addCable(Cable $cable): void
    {
        $this->cables[] = $cable;
        $i = $this->cables->lastKey();
        $this->cableMap[$cable->getA()] = $i;
        $this->cableMap[$cable->getB()] = $i;
    }

    /**
     * get specific cable.
     */
    public function getCableByChar(string $char): ?Cable
    {
        return $this->cables[$this->cableMap[strtoupper($char)]] ?? null;
    }

    /*
     * remove a cable from the steckbrett.
     */
    public function removeCable(Cable $cable): void
    {
        if (!$this->cableMap->offsetExists($cable->getA()) || !$this->cableMap->offsetExists($cable->getB())) {
            throw new InvalidCableException('Cable '.(string) $cable.' not found');
        }

        unset($this->cables[$this->cableMap[$cable->getA()]]);
        unset($this->cableMap[$cable->getA()]);
        unset($this->cableMap[$cable->getB()]);
    }

    /**
     * process character trought steckbrett.
     */
    public function __invoke(string $char): string
    {
        return ($this->cables[$this->cableMap[$char] ?? -1] ?? function ($char) {return $char; })($char);
    }

    /**
     * convert object to array.
     */
    public function __toArray(): array
    {
        return $this->cables
                    ->map(fn ($cable) => (string) $cable)
                    ->__toArray();
    }

    /**
     * convert object to string.
     */
    public function __toString(): string
    {
        return implode(' ', $this->__toArray());
    }
}
