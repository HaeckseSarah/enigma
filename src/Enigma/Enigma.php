<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma;

use HaeckseSarah\Enigma\Rotor\RotorInterface;
use HaeckseSarah\Enigma\Steckbrett\Cable;
use HaeckseSarah\Enigma\Steckbrett\SteckbrettInterface;
use HaeckseSarah\Enigma\Walzenwerk\WalzenwerkInterface;

/**
 * Enigma.
 */
class Enigma
{
    protected $walzenwerk; // walzenwerk
    protected $steckbrett; // steckbrett

    /**
     * Constructor.
     */
    public function __construct(WalzenwerkInterface $walzenwerk, SteckbrettInterface $steckbrett)
    {
        $this->walzenwerk = $walzenwerk;
        $this->steckbrett = $steckbrett;
    }

    /**
     * replace rotor.
     */
    public function replaceRotor(int $rotorIndex, RotorInterface $rotor): void
    {
        $this->walzenwerk->replaceRotor($rotorIndex, $rotor);
    }

    /**
     * rotate specific rotor.
     */
    public function moveRotor(int $rotorIndex, int $steps): void
    {
        $this->walzenwerk->moveRotor($rotorIndex, $steps);
    }

    /**
     * rotate specific rotor.
     */
    public function setRotorPosition(int $rotorIndex, int $position): void
    {
        $this->walzenwerk->setRotorPosition($rotorIndex, $position);
    }

    /**
     * add a cable to the steckbrett.
     */
    public function addCable(Cable $cable): void
    {
        $this->steckbrett->addCable($cable);
    }

    /*
     * remove a cable from the steckbrett.
     */
    public function removeCable(Cable $cable): void
    {
        $this->steckbrett->removeCable($cable);
    }

    /**
     * encrypt input.
     */
    public function __invoke(string $input): string
    {
        $result = '';

        foreach (str_split($this->sanitizeInput($input)) as $char) {
            $result .= $this->processChar($char);
        }

        return $result;
    }

    /**
     * encryption process in machine.
     *
     * Input -> Steckbrett -> Walzenwerk -> Steckbrett -> Output
     */
    protected function processChar(string $char): string
    {
        $char = ($this->steckbrett)(
            ($this->walzenwerk)(
                ($this->steckbrett)($char)
            )
        );

        return $char;
    }

    /**
     * format to uppercase
     * remove non alpha characters.
     */
    protected function sanitizeInput(string $input): string
    {
        return preg_replace('/[^A-Z]/', '', strtoupper($input));
    }

    /**
     * convert object to array.
     */
    public function __toArray(): array
    {
        return [
            'walzenwerk' => $this->walzenwerk->__toArray(),
            'steckbrett' => $this->steckbrett->__toArray(),
        ];
    }

    public function __toString()
    {
        return $this->walzenwerk->__toString().' / '.$this->steckbrett->__toString();
    }
}
