<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

/**
 * Rotor Type IV.
 */
class IV extends Definition
{
    protected $type = 'IV';

    protected $map = [
        'A' => 'E',
        'B' => 'S',
        'C' => 'O',
        'D' => 'V',
        'E' => 'P',
        'F' => 'Z',
        'G' => 'J',
        'H' => 'A',
        'I' => 'Y',
        'J' => 'Q',
        'K' => 'U',
        'L' => 'I',
        'M' => 'R',
        'N' => 'H',
        'O' => 'X',
        'P' => 'L',
        'Q' => 'N',
        'R' => 'F',
        'S' => 'T',
        'T' => 'G',
        'U' => 'K',
        'V' => 'D',
        'W' => 'C',
        'X' => 'M',
        'Y' => 'W',
        'Z' => 'B',
    ];

    protected $pins = [9]; // [J]
}
