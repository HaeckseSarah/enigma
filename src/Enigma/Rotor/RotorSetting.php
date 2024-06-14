<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor;

/**
 * Initial Settings for a rotor.
 */
class RotorSetting
{
    private $type;
    private $rotation;
    private $ringPosition;

    public function __construct(string $type, string $rotation = 'A', int $ringPosition = 0)
    {
        $this->setType($type);
        $this->setRotation($rotation);
        $this->setRingPosition($ringPosition);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getRotation(): string
    {
        return $this->rotation;
    }

    public function setRotation(string $rotation)
    {
        $this->rotation = strtoupper($rotation);
    }

    public function getRingPosition(): int
    {
        return $this->ringPosition;
    }

    public function setRingPosition(int $ringPosition)
    {
        $this->ringPosition = $ringPosition;
    }
}
