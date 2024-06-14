<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli\Ui;

use HaeckseSarah\Enigma\Interface\Cli\Ui;

/**
 * statusbar ui element.
 */
class StatusBar
{
    protected $row;
    protected $col;
    protected $parent;

    protected $buttons;

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
     * adds a button to the bar.
     */
    public function setButton($index, $text): void
    {
        $this->buttons[$index] = $text;
    }

    /**
     * draw statusbar.
     */
    public function draw(bool $hideButtons = false): void
    {
        if (!$hideButtons) {
            UiHelper::setCursor($this->row + 1, 0);
            foreach ($this->buttons as $index => $btn) {
                echo ' ';
                $this->drawButton("$index $btn");
            }
        }

        UiHelper::setCursor($this->row, 0);
        echo ' ';
        UiHelper::setColor(30, 47);
        echo ' '.str_pad($this->parent->getEnigmaStatusString(), 104);
        UiHelper::resetColor();
    }

    /**
     * draw a button.
     */
    private function drawButton(string $text): void
    {
        UiHelper::setColor(30, 47);
        echo ' '.$text.' ';
        UiHelper::resetColor();
    }
}
