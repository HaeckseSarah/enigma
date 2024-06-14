<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Walzenwerk;

use HaeckseSarah\Enigma\Rotor\RotorInterface;
use HaeckseSarah\Enigma\Rotor\UmkehrwalzeInterface;

/**
 * Walzenwerk
 * combines ETW, Rotors and UKW.
 */
class Walzenwerk implements WalzenwerkInterface
{
    protected $ukw;
    protected $rotors;

    public function __construct(UmkehrwalzeInterface $ukw, RotorInterface ...$rotors)
    {
        $this->ukw = $ukw;
        $this->rotors = $rotors;
    }

    /**
     * rotate specific rotor.
     */
    public function setRotorPosition(int $rotorIndex, int $position): void
    {
        $this->rotors[$rotorIndex]->setOffset($position);
    }

    /**
     * rotate specific rotor.
     */
    public function moveRotor(int $rotorIndex, int $steps): void
    {
        $this->rotors[$rotorIndex]->move($steps);
    }

    /**
     * replace rotor.
     */
    public function replaceRotor(int $rotorIndex, RotorInterface $rotor): void
    {
        $this->rotors[$rotorIndex] = $rotor;
    }

    /**
     * process character.
     */
    public function __invoke(string $char, int $rotationMode = self::WW_ROTATION_DOUBLESTEP): string
    {
        // rotate rotor
        if (self::WW_ROTATION_OFF != $rotationMode) {
            $this->rotate(self::WW_ROTATION_DOUBLESTEP === $rotationMode);
        }

        // ETW
        $index = charToIndex($char);

        // Rotors from right to left
        for ($i = count($this->rotors) - 1; $i >= 0; --$i) {
            $index = $this->rotors[$i]->right($index);
        }

        // UKW
        $index = ($this->ukw)($index);

        // Rotors from left to right
        for ($i = 0; $i < count($this->rotors); ++$i) {
            $index = $this->rotors[$i]->left($index);
        }

        // ETW
        return indexToChar($index);
    }

    /**
     * logic for rotator rotation.
     *
     * @param bool $doubleStep simulate double step bug in original enigma
     */
    private function rotate($doubleStep = true): void
    {
        for ($i = count($this->rotors) - 1; $i >= 0; --$i) {
            $this->rotors[$i]->next();

            // doublestep
            if ($doubleStep && $i > 0 && $this->rotors[$i - 1]->isPin(1) && $this->rotors[$i]->isPin(-1)) {
                continue;
            }

            if (!$this->rotors[$i]->isPin()) {
                return;
            }
        }
    }

    /**
     * convert object to array.
     */
    public function __toArray(): array
    {
        return [
            'ukw' => $this->ukw->__toArray(),
            'rotors' => array_map(function ($rotor) {return $rotor->__toArray(); }, $this->rotors),
        ];
    }

    /**
     * convert object to string.
     */
    public function __toString(): string
    {
        $t = [];
        $r = [];
        $p = [];
        foreach ($this->rotors as $rotor) {
            [$type,$ring,$position] = explode(' ', $rotor->__toString());
            $t[] = $type;
            $r[] = sprintf('%02d', $ring + 1);
            $p[] = indexToChar((int) $position);
        }

        return $this->ukw->getType().' '.implode('-', $t).' ('.implode(',', $p).') / '.implode(' ', $r);
    }
}
