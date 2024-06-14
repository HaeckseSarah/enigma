<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli\Ui;

use HaeckseSarah\Enigma\Interface\Cli\Ui;

class Walzen
{
    protected $row;
    protected $col;
    protected $parent;

    /**
     * constructor.
     */
    public function __construct(int $row, int $col, Ui &$parent)
    {
        $this->row = $row;
        $this->col = $col;
        $this->parent = $parent;
    }

    /**
     * draws current walzen state.
     */
    public function draw(): void
    {
        $data = $this->parent->getEnigmaStatus();
        $rotors = $data['walzenwerk']['rotors'];
        foreach ($rotors as $i => $rotor) {
            UiHelper::resetColor();
            UiHelper::setCursor($this->row, $this->col + ($i * 2));
            echo indexToChar($rotor['rotation']);
        }
    }
}
