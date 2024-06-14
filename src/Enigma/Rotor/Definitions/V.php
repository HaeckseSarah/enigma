<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

/**
 * Rotor Type V.
 */
class V extends Definition
{
    protected $type = 'V';

    protected $map = [
        'A' => 'V',
        'B' => 'Z',
        'C' => 'B',
        'D' => 'R',
        'E' => 'G',
        'F' => 'I',
        'G' => 'T',
        'H' => 'Y',
        'I' => 'U',
        'J' => 'P',
        'K' => 'S',
        'L' => 'D',
        'M' => 'N',
        'N' => 'H',
        'O' => 'L',
        'P' => 'X',
        'Q' => 'A',
        'R' => 'W',
        'S' => 'M',
        'T' => 'J',
        'U' => 'Q',
        'V' => 'O',
        'W' => 'F',
        'X' => 'E',
        'Y' => 'C',
        'Z' => 'K',
    ];

    protected $pins = [25]; // [Z]
}
