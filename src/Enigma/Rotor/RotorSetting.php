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

    public function __construct($type, $rotation = 'A', $ringPosition = 0)
    {
        $this->setType($type);
        $this->setRotation($rotation);
        $this->setRingPosition($ringPosition);
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getRotation()
    {
        return $this->rotation;
    }

    public function setRotation($rotation)
    {
        $this->rotation = strtoupper($rotation);
    }

    public function getRingPosition()
    {
        return $this->ringPosition;
    }

    public function setRingPosition($ringPosition)
    {
        $this->ringPosition = $ringPosition;
    }
}
