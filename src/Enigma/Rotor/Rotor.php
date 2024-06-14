<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor;

use HaeckseSarah\Enigma\Exception\InvalidRingPositionException;
use HaeckseSarah\Enigma\Lib\Collection;
use HaeckseSarah\Enigma\Lib\CollectionInterface;

/**
 * Single Rotor.
 */
class Rotor implements RotorInterface
{
    protected $type = '';
    protected $map;
    protected $ringPosition;
    protected $pins = [];

    protected $offset = 0;

    /**
     * Constructor.
     *
     * @param CollectionInterface $mapping      Rotator character map
     * @param CollectionInterface $pins         Pin configuration
     * @param string              $type         Rotator Type - presentation only, has no effect on processing
     * @param int                 $ringPosition Ring position
     */
    public function __construct(CollectionInterface $mapping, CollectionInterface $pins, string $type = '', $ringPosition = 0)
    {
        $this->offset = 0;
        $this->type = $type;

        if ($ringPosition < 0 || $ringPosition > 25) {
            throw new InvalidRingPositionException("Invalid value: $ringPosition");
        }

        $this->ringPosition = $ringPosition;
        $this->pins = $pins;

        $shiftedMap = $this->shiftMap($mapping, $ringPosition);
        $this->map = $this->calculateMappings($shiftedMap);
    }

    /**
     * convert char-to-char map into indexed format.
     */
    private function calculateMappings(CollectionInterface $mapping): CollectionInterface
    {
        $result = ['ltr' => [], 'rtl' => []];

        for ($i = 0; $i < 26; ++$i) {
            $letter = indexToChar($i);
            $result['rtl'][$i] = charToIndex($mapping[$letter]);

            $result['ltr'][$i] = charToIndex($mapping->search($letter));
        }

        return new Collection($result);
    }

    /**
     * get Rotator Type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * process character from left to right.
     *
     * todo validate input
     */
    public function left(int $index): int
    {
        return $this->calculateOutput($index, 'ltr');
    }

    /**
     * process character from right to left.
     *
     * todo validate input
     */
    public function right(int $index): int
    {
        return $this->calculateOutput($index, 'rtl');
    }

    /**
     * process character.
     */
    private function calculateOutput(int $index, string $map): int
    {
        // apply current rotation to index
        $realIndex = normalizeIndex($index + $this->current());

        // get output index
        $newIndex = $this->map[$map][$realIndex];

        // apply current rotation to output
        return normalizeIndex($newIndex - $this->current());
    }

    /**
     * set current rotation.
     */
    public function setOffset(int $offset): void
    {
        $this->offset = normalizeIndex($offset);
    }

    /**
     * Move rotor x steps.
     */
    public function move(int $steps): void
    {
        $this->setOffset(normalizeIndex($this->current() + $steps));
    }

    /**
     * get current position.
     */
    public function current(): int
    {
        return $this->offset;
    }

    /**
     * get current position.
     */
    public function key(): int
    {
        return $this->current();
    }

    /**
     * rotate.
     */
    public function next(): void
    {
        $this->offset = normalizeIndex($this->offset + 1);
    }

    /**
     * reset rotation to 0.
     */
    public function rewind(): void
    {
        $this->offset = 0;
    }

    /**
     * always true, because its infinite.
     */
    public function valid(): bool
    {
        return true;
    }

    /**
     * check, if current rotation has a pin, to move forward next rotor.
     *
     * @param int $offset check for pin relatively
     */
    public function isPin($offset = 0): bool
    {
        $p = normalizeIndex($this->current() - 1 + $offset);

        return $this->pins->has($p);
    }

    /**
     * calculate new map for ringstellung.
     */
    protected function shiftMap(Collection $mapping, int $pos): CollectionInterface
    {
        $newMap = [];
        foreach ($mapping as $l => $r) {
            $newMap[indexToChar(normalizeIndex(charToIndex($l) + $pos))] = indexToChar(normalizeIndex(charToIndex($r) + $pos));
        }

        return new Collection($newMap);
    }

    /**
     * convert object to array.
     */
    public function __toArray(): array
    {
        return [
            'type' => $this->type,
            'ringPosition' => $this->ringPosition,
            'rotation' => $this->current(),
        ];
    }

    /**
     * convert object to string.
     */
    public function __toString(): string
    {
        return implode(' ', [$this->type, $this->ringPosition, $this->current()]);
    }
}
