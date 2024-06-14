<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli\Ui;

/**
 * keyboard ui element
 * style: neo2.
 */
class KeyboardNeo extends Keyboard
{
    protected $keyMap = [
        'X' => [1, 2],
        'V' => [1, 4],
        'L' => [1, 6],
        'C' => [1, 8],
        'W' => [1, 10],
        'K' => [1, 12],
        'H' => [1, 14],
        'G' => [1, 16],
        'F' => [1, 18],
        'Q' => [1, 20],
        'ß' => [1, 22],

        'U' => [2, 3],
        'I' => [2, 5],
        'A' => [2, 7],
        'E' => [2, 9],
        'O' => [2, 11],
        'S' => [2, 13],
        'N' => [2, 15],
        'R' => [2, 17],
        'T' => [2, 19],
        'D' => [2, 21],
        'Y' => [2, 23],

        'Ü' => [3, 4],
        'Ö' => [3, 6],
        'Ä' => [3, 8],
        'P' => [3, 10],
        'Z' => [3, 12],
        'B' => [3, 14],
        'M' => [3, 16],
        ',' => [3, 18],
        '.' => [3, 20],
        'J' => [3, 22],
    ];

    /**
     * draws the keyboard.
     */
    public function draw(): void
    {
        UiHelper::resetColor();
        UiHelper::setCursor($this->row, $this->col);
        echo '┌────────────────────────┐';
        UiHelper::setCursor($this->row + 1, $this->col);
        echo "│                        │\n";
        UiHelper::setCursor($this->row + 2, $this->col);
        echo "│                        │\n";
        UiHelper::setCursor($this->row + 3, $this->col);
        echo "│                        │\n";
        UiHelper::setCursor($this->row + 4, $this->col);
        echo "└────────────────────────┘\n";

        $this->drawKeys();
    }
}
