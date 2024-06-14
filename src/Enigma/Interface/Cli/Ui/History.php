<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli\Ui;

use HaeckseSarah\Enigma\Lib\Collection;

/**
 * graphical element, to show history of inserted characters and their decoded value.
 */
class History
{
    protected $row;
    protected $col;

    protected $curCol;
    protected $curRow;

    protected $buffer;
    protected $bufferSize = 8;

    /**
     * constructor.
     */
    public function __construct(int $row, int $col)
    {
        $this->row = $row;
        $this->col = $col;

        $this->curCol = 0;
        $this->curRow = 0;
        $this->clearBuffer();
    }

    /**
     * reset buffer.
     */
    private function clearBuffer(): void
    {
        $this->buffer = new Collection();
        for ($i = 1; $i <= $this->bufferSize; ++$i) {
            $this->buffer[] = new Collection();
        }
    }

    /**
     * output the wireframe.
     */
    public function draw(): void
    {
        UiHelper::resetColor();
        UiHelper::setCursor($this->row, $this->col);
        echo '┌───────────────────────────────┬───────────────────────────────┐';
        for ($i = 3; $i <= $this->bufferSize; ++$i) {
            $this->clearRow($i);
        }
        UiHelper::setCursor($this->row + $this->bufferSize + 1, $this->col);
        echo '└───────────────────────────────┴───────────────────────────────┘';
        $this->printBuffer();
    }

    /**
     * empty a row.
     */
    public function clearRow(int $row): void
    {
        UiHelper::setCursor($this->row + $row, $this->col);
        echo '│                               │                               │';
    }

    /**
     * prints the current buffer.
     */
    public function printBuffer(): void
    {
        foreach ($this->buffer as $row => $cols) {
            $this->clearRow($row + 1);
            foreach ($cols as $col => $char) {
                UiHelper::setCursor($this->row + $row + 1, $this->col + $col);
                echo $char;
            }
        }
    }

    /**
     * add a character to the buffer and print it.
     *
     * todo: validate input (only one character allowed)
     */
    public function print(string $a, string $b): void
    {
        ++$this->curCol;
        if (0 === $this->curCol % 6) {
            ++$this->curCol;
        }
        if ($this->curCol > 30) {
            $this->curCol = 1;
            ++$this->curRow;
            if ($this->curRow >= $this->bufferSize) {
                $this->buffer->shift();
                $this->curRow = $this->bufferSize - 1;
                $this->printBuffer();
            }
        }
        UiHelper::resetColor();
        $this->buffer[$this->curRow][$this->curCol + 1] = $a;
        $this->buffer[$this->curRow][$this->curCol + 33] = $b;
        $this->printBuffer();
    }
}
