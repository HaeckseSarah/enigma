<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli\Ui;

/**
 * graphical element for a keyboard.
 */
class Keyboard
{
    protected $row;
    protected $col;
    protected $keyMap = [
        'Q' => [1, 2],
        'W' => [1, 4],
        'E' => [1, 6],
        'R' => [1, 8],
        'T' => [1, 10],
        'Z' => [1, 12],
        'U' => [1, 14],
        'I' => [1, 16],
        'O' => [1, 18],
        'A' => [2, 3],
        'S' => [2, 5],
        'D' => [2, 7],
        'F' => [2, 9],
        'G' => [2, 11],
        'H' => [2, 13],
        'J' => [2, 15],
        'K' => [2, 17],
        'P' => [3, 2],
        'Y' => [3, 4],
        'X' => [3, 6],
        'C' => [3, 8],
        'V' => [3, 10],
        'B' => [3, 12],
        'N' => [3, 14],
        'M' => [3, 16],
        'L' => [3, 18],
    ];

    protected $highligtedKey = 'A';

    protected $styles;

    /**
     * constructor.
     */
    public function __construct(int $row, int $col, ?array $styles = null)
    {
        $this->row = $row;
        $this->col = $col;
        $this->styles = $styles ?? ['normal' => [0, 0], 'highlight' => [33, 0]];
    }

    /**
     * draws the keyboard.
     */
    public function draw(): void
    {
        UiHelper::resetColor();
        UiHelper::setCursor($this->row, $this->col);
        echo '┌───────────────────┐';
        UiHelper::setCursor($this->row + 1, $this->col);
        echo "│                   │\n";
        UiHelper::setCursor($this->row + 2, $this->col);
        echo "│                   │\n";
        UiHelper::setCursor($this->row + 3, $this->col);
        echo "│                   │\n";
        UiHelper::setCursor($this->row + 4, $this->col);
        echo "└───────────────────┘\n";

        $this->drawKeys();
    }

    /**
     * draws all keys in the keyboard.
     */
    public function drawKeys(): void
    {
        foreach ($this->keyMap as $key => $coords) {
            $this->drawKey($key, $this->styles['normal']);
        }
    }

    /**
     * draws a specific key.
     *
     * todo: validate input (check if key is defined)
     */
    public function drawKey(string $key, array $style = [0, 0]): void
    {
        UiHelper::setColor(...$style);
        UiHelper::setCursor($this->row + $this->keyMap[$key][0], $this->col + $this->keyMap[$key][1]);
        echo $key;
    }

    /**
     * draw a key in highlighted state.
     *
     * todo: validate input
     */
    public function highligtKey(string $key): void
    {
        $this->drawKey($this->highligtedKey, $this->styles['normal']);
        $this->highligtedKey = $key;
        $this->drawKey($key, $this->styles['highlight']);
    }
}
