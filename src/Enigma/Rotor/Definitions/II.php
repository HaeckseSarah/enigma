<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

/**
 * Rotor Type II.
 */
class II extends Definition
{
    protected $type = 'II';

    protected $map = [
        'A' => 'A',
        'B' => 'J',
        'C' => 'D',
        'D' => 'K',
        'E' => 'S',
        'F' => 'I',
        'G' => 'R',
        'H' => 'U',
        'I' => 'X',
        'J' => 'B',
        'K' => 'L',
        'L' => 'H',
        'M' => 'W',
        'N' => 'T',
        'O' => 'M',
        'P' => 'C',
        'Q' => 'Q',
        'R' => 'G',
        'S' => 'Z',
        'T' => 'N',
        'U' => 'P',
        'V' => 'Y',
        'W' => 'F',
        'X' => 'V',
        'Y' => 'O',
        'Z' => 'E',
    ];

    protected $pins = [4]; // [E]
}
